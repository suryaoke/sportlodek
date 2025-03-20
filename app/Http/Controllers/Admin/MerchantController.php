<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MechantCategoryStoreRequest;
use App\Http\Requests\MechantCategoryUpdateRequest;
use App\Http\Requests\MerchantDetailStoreRequest;
use App\Http\Requests\MerchantDetailUpdateRequest;
use App\Http\Requests\MerchantStoreRequest;
use App\Http\Requests\MerchantUpdateRequest;
use App\Models\Merchant;
use App\Models\MerchantDetail;
use App\Models\MerchantDetailCategory;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Traits\FileUpload;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class MerchantController extends Controller
{
    use FileUpload;
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $merchants = Merchant::paginate(10);
        return view('admin.merchant.index', compact('merchants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengambil pengguna dengan role 'merchant' saja
        $users = User::role('merchant')->latest();

        // Mengambil nama dan id dari pengguna yang terfilter
        $userOptions = $users->pluck('name', 'id')->toArray();

        // Mengirim data ke view
        return view('admin.merchant.create', compact('userOptions'));
    }

    /** Store a newly created resource in storage.
     */
    public function store(MerchantStoreRequest $request): RedirectResponse
    {
        $imagePath = $this->uploadFile($request->file('image'));
        $merchant = new Merchant();
        $merchant->user_id = $request->user;
        $merchant->name = $request->name;
        $merchant->about = $request->about;
        $merchant->address = $request->address;
        $merchant->image = $imagePath;
        $merchant->save();

        notyf()->success("Created Successfully!");

        return to_route('admin.merchant.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Merchant $merchant)
    {

        // Mengambil pengguna dengan role 'merchant' saja
        $users = User::role('merchant')->latest();

        // Mengambil nama dan id dari pengguna yang terfilter
        $userOptions = $users->pluck('name', 'id')->toArray();


        return view('admin.merchant.edit', compact('merchant', 'userOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MerchantUpdateRequest $request, Merchant $merchant)
    {
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadFile($request->file('image'));
            $this->deleteFile($merchant->image);
            $merchant->image = $imagePath;
        }

        $merchant->user_id = $request->user;
        $merchant->name = $request->name;
        $merchant->about = $request->about;
        $merchant->address = $request->address;

        $merchant->save();


        notyf()->success("Updated Successfully!");

        return to_route('admin.merchant.index');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Merchant $merchant)
    {
        try {
            // Mengambil semua detail merchant berdasarkan ID merchant
            $merchantDetails = MerchantDetail::where('merchant_id', $merchant->id)->get();

            foreach ($merchantDetails as $merchantDetail) {
                // Mengambil semua kategori detail merchant berdasarkan ID merchant_detail
                $merchantDetailCategories = MerchantDetailCategory::where('merchant_detail_id', $merchantDetail->id)->get();

                foreach ($merchantDetailCategories as $merchantDetailCategory) {
                    // Mengambil semua schedule berdasarkan ID merchant_detail_category
                    $schedules = Schedule::where('merchant_detail_category_id', $merchantDetailCategory->id)->get();

                    foreach ($schedules as $schedule) {
                        // Mengambil semua detail schedule berdasarkan ID schedule
                        $scheduleDetails = ScheduleDetail::where('schedule_id', $schedule->id)->get();

                        // Menghapus scheduleDetails
                        if ($scheduleDetails->isNotEmpty()) {
                            $scheduleDetails->each->delete();
                        }

                        // Menghapus schedules
                        $schedule->delete();
                    }

                    // Menghapus merchantDetailCategory
                    $merchantDetailCategory->delete();
                }

                // Menghapus merchantDetail
                $merchantDetail->delete();
            }

            // Menghapus gambar merchant jika ada
            if ($merchant->image && file_exists(public_path('path/to/images/' . $merchant->image))) {
                $this->deleteFile($merchant->image);
            }

            // Menghapus merchant
            $merchant->delete();

            // Menampilkan notifikasi sukses
            notyf()->success('Deleted Successfully!');
            return response(['message' => 'Deleted Successfully!'], 200);
        } catch (Exception $e) {
            logger("Merchant Language Error >> " . $e);
            return response(['message' => 'Something went wrong!'], 500);
        }
    }


    public function akunStore(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('merchant');
        UserDetail::create([
            'user_id' => $user->id,
        ]);

        notyf()->success("User Account Created Successfully!");

        return to_route('admin.merchant.create');
    }

    public function detail(Merchant $merchant, $id = null)
    {
        $merchantDetails = MerchantDetail::where('merchant_id', $merchant->id)->orderBy('name', 'asc')->get();
        $open = MerchantDetail::pluck('name', 'id')->toArray();

        $selectedDetail = $id ? MerchantDetail::find($id) : null;

        // Ambil data MerchantDetailCategory sesuai dengan id MerchantDetail yang dipilih
        $detailCategories = $selectedDetail
            ? MerchantDetailCategory::where('merchant_detail_id', $selectedDetail->id)->orderBy('name', 'asc')->get()
            : collect(); // jika tidak ada data, kembalikan collection kosong

        return view('admin.merchant.detail', compact('detailCategories', 'merchant', 'merchantDetails', 'selectedDetail'));
    }



    public function detailStore(MerchantDetailStoreRequest $request): RedirectResponse
    {

        $merchantDetail = new MerchantDetail();
        $merchantDetail->merchant_id = $request->merchant_id;
        $merchantDetail->name = $request->name;
        $merchantDetail->desc = $request->desc;
        $merchantDetail->status = "1";
        $merchantDetail->open = $request->open;
        $merchantDetail->close = $request->close;
        $merchantDetail->type = $request->type;
        $merchantDetail->save();

        notyf()->success("Created Successfully!");

        return redirect()->back();
    }


    public function detailUpdate(MerchantDetailUpdateRequest $request)
    {

        $merchantDetail = MerchantDetail::findOrFail($request->id);


        $merchantDetail->name = $request->name;
        $merchantDetail->desc = $request->desc;
        $merchantDetail->open = $request->open;
        $merchantDetail->close = $request->close;
        $merchantDetail->type = $request->type;
        $merchantDetail->save();

        notyf()->success("Updated Successfully!");
        return redirect()->back();
    }

    public function merchantDetailStatusUpdate(Request $request): RedirectResponse
    {
        $request->validate(['status' => ['required', 'in:0,1']]);

        $merchantDetail = MerchantDetail::findOrFail($request->id);

        $merchantDetail->status = $request->status;
        $merchantDetail->save();

        notyf()->success("Updated Successfully!");

        return redirect()->back();
    }

    public function categoryStore(MechantCategoryStoreRequest $request): RedirectResponse
    {


        $merchantCategory = new MerchantDetailCategory();
        $merchantCategory->merchant_detail_id = $request->merchant_detail_id;
        $merchantCategory->name = $request->name;
        $merchantCategory->price = $request->price;
        $merchantCategory->save();

        notyf()->success("Created Successfully!");

        return redirect()->back();
    }

    public function categoryUpdate(MechantCategoryUpdateRequest $request)
    {

        $merchantCategory = MerchantDetailCategory::findOrFail($request->id);


        $merchantCategory->name = $request->name;
        $merchantCategory->price = $request->price;
        $merchantCategory->save();

        notyf()->success("Updated Successfully!");
        return redirect()->back();
    }

    public function mechantDetailDestroy($id)
    {
        try {
            $merchantDetail = MerchantDetail::findOrFail($id);

            // Cari semua kategori yang terkait, karena kemungkinan ada lebih dari satu
            $merchantCategories = MerchantDetailCategory::where('merchant_detail_id', $id)->get();

            // Iterasi melalui semua kategori untuk menemukan schedule dan schedule detail terkait
            foreach ($merchantCategories as $merchantCategory) {
                $schedules = Schedule::where('merchant_detail_category_id', $merchantCategory->id)->get();

                foreach ($schedules as $schedule) {
                    $scheduleDetails = ScheduleDetail::where('schedule_id', $schedule->id)->get();

                    // Hapus semua schedule details terkait
                    if ($scheduleDetails->isNotEmpty()) {
                        foreach ($scheduleDetails as $scheduleDetail) {
                            $scheduleDetail->delete();
                        }
                    }

                    // Hapus schedule terkait
                    $schedule->delete();
                }

                // Hapus kategori terkait
                $merchantCategory->delete();
            }

            // Hapus merchant detail setelah semua data terkait dihapus
            $merchantDetail->delete();

            notyf()->success('Deleted Successfully!');
            return response(['message' => 'Deleted Successfully!'], 200);
        } catch (\Exception $e) {
            logger("Merchant Detail Error >> " . $e->getMessage());
            return response(['message' => 'Something went wrong!'], 500);
        }
    }



    public function mechantCategoryDestroy($id)
    {
        try {
            // Mengambil data MerchantDetailCategory berdasarkan id
            $merchantCategory = MerchantDetailCategory::findOrFail($id);

            // Menghapus ScheduleDetail yang terkait langsung dengan Schedule
            ScheduleDetail::whereIn('schedule_id', function ($query) use ($merchantCategory) {
                $query->select('id')
                    ->from('schedules')
                    ->where('merchant_detail_category_id', $merchantCategory->id);
            })->delete();

            // Menghapus Schedule yang terkait dengan MerchantDetailCategory
            Schedule::where('merchant_detail_category_id', $merchantCategory->id)->delete();

            // Menghapus MerchantDetailCategory
            $merchantCategory->delete();

            // Memberikan notifikasi berhasil
            notyf()->success('Deleted Successfully!');
            return response(['message' => 'Deleted Successfully!'], 200);
        } catch (\Exception $e) {
            // Log error yang lebih deskriptif
            logger()->error("Error deleting Merchant Category: {$e->getMessage()}", ['exception' => $e]);
            return response(['message' => 'Something went wrong!'], 500);
        }
    }
}
