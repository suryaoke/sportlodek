<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleDetailStoreRequest;
use App\Http\Requests\ScheduleDetailUpdateRequest;
use App\Http\Requests\ScheduleStoreRequest;
use App\Http\Requests\ScheduleUpdateRequest;
use App\Models\Merchant;
use App\Models\MerchantDetail;
use App\Models\MerchantDetailCategory;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(): View
    {
        $merchants = Merchant::paginate(10);
        return view('admin.schedule.index', compact('merchants'));
    }

    public function detail(Merchant $merchant, $id = null, $scheduleId = null, $scheduleDetailId = null)
    {
        $merchantDetails = MerchantDetail::where('merchant_id', $merchant->id)
            ->where('status', '1')
            ->orderBy('name', 'asc')
            ->get();
        $open = MerchantDetail::pluck('name', 'id')->toArray();

        $selectedDetail = $id ? MerchantDetail::find($id) : null;

        // Ambil data MerchantDetailCategory sesuai dengan id MerchantDetail yang dipilih
        $detailCategories = $selectedDetail
            ? MerchantDetailCategory::where('merchant_detail_id', $selectedDetail->id)
            ->orderBy('name', 'asc')
            ->get()
            : collect(); // jika tidak ada data, kembalikan collection kosong


        $selectedSchedule = $scheduleId ? MerchantDetailCategory::find($scheduleId) : null;


        $schedules = $selectedSchedule
            ? Schedule::where('merchant_detail_category_id', $selectedSchedule->id)->orderBy('date', 'desc')->get()
            : collect(); // jika tidak ada data, kembalikan collection kosong



        $selectedScheduleDetail = $scheduleDetailId ? Schedule::find($scheduleDetailId) : null;


        $scheduleDetails = $selectedScheduleDetail
            ? ScheduleDetail::where('schedule_id', $selectedScheduleDetail->id)->get()
            : collect(); // jika tidak ada data, kembalikan collection kosong


        return view('admin.schedule.detail', compact('selectedScheduleDetail', 'scheduleDetails', 'selectedScheduleDetail', 'schedules', 'detailCategories', 'merchant', 'merchantDetails', 'selectedDetail', 'selectedSchedule'));
    }


    public function Store(ScheduleStoreRequest $request): RedirectResponse
    {

        $schedule = new Schedule();
        $schedule->merchant_detail_category_id = $request->merchant_detail_category_id;
        $schedule->name = $request->name;
        $schedule->date = $request->date;
        $schedule->save();

        notyf()->success("Created Successfully!");

        return redirect()->back();
    }

    public function update(ScheduleUpdateRequest $request): RedirectResponse
    {

        $schedule = Schedule::findOrFail($request->id);
        $schedule->name = $request->name;
        $schedule->date = $request->date;
        $schedule->save();

        notyf()->success("Update Successfully!");

        return redirect()->back();
    }


    public function scheduleDestroy($id)
    {
        try {
            $schedule = Schedule::findOrFail($id);


            $scheduleDetail = ScheduleDetail::where('schedule_id', $id)->get();

            if ($scheduleDetail->isNotEmpty()) {
                foreach ($scheduleDetail as $scheduleDetails) {
                    $scheduleDetails->delete();
                }
            }

            $schedule->delete();
            notyf()->success('Deleted Successfully!');
            return response(['message' => 'Deleted Successfully!'], 200);
        } catch (\Exception $e) {
            logger("Merchant Language Error >> " . $e);
            return response(['message' => 'Something went wrong!'], 500);
        }
    }

    public function schedulDetailStore(ScheduleDetailStoreRequest $request): RedirectResponse
    {

        $scheduleDetail = new ScheduleDetail();
        $scheduleDetail->schedule_id = $request->schedule_id;
        $scheduleDetail->in = $request->in;
        $scheduleDetail->out = $request->out;
        $scheduleDetail->status = '1';
        $scheduleDetail->save();

        notyf()->success("Created Successfully!");

        return redirect()->back();
    }

    public function scheduleDetailUpdate(ScheduleDetailUpdateRequest $request): RedirectResponse
    {
        // dd($request->all());

        $scheduleDetail = ScheduleDetail::findOrFail($request->id);
        $scheduleDetail->in = $request->in;
        $scheduleDetail->out = $request->out;
        $scheduleDetail->save();

        notyf()->success("Updated Successfully!");

        return redirect()->back();
    }

    public function scheduleDetailDestroy($id)
    {
        try {
            $scheduleDetail = ScheduleDetail::findOrFail($id);
            $scheduleDetail->delete();
            notyf()->success('Deleted Successfully!');
            return response(['message' => 'Deleted Successfully!'], 200);
        } catch (\Exception $e) {
            logger("Merchant Language Error >> " . $e);
            return response(['message' => 'Something went wrong!'], 500);
        }
    }
}
