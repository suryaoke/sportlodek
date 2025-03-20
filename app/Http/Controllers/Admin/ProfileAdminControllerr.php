<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\UserDetail;
use App\Traits\FileUpload;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileAdminControllerr extends Controller
{

    use FileUpload;

    public function profile(): View
    {

        $userDetail = UserDetail::where('user_id', Auth::user()->id)->first();
        return view('admin.profile.index', compact('userDetail'));
    }

    public function password(): View
    {
        return view('admin.profile.password');
    }


    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $userDetail = UserDetail::where('user_id', Auth::user()->id)->first();
        $userDetail->phone = $request->phone;
        $userDetail->address = $request->address;
        $userDetail->save();

        notyf()->success("User Account Updated Successfully!");

        return to_route('admin.profile');
    }



    public function storeImage(Request $request): RedirectResponse
    {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Ambil detail pengguna yang login
        $userDetail = UserDetail::where('user_id', Auth::user()->id)->first();

        if ($userDetail->image && file_exists(public_path('path/to/images/' .  $userDetail->image))) {
            $this->deleteFile($userDetail->image);
        }
        $userDetail->image = null;

        // Unggah file gambar
        $imagePath = $this->uploadFile($request->file('image'));

        // Simpan path gambar di database
        $userDetail->image = $imagePath;
        $userDetail->save();

        notyf()->success("Image uploaded successfully!");

        // Redirect ke halaman lain
        return to_route('admin.profile');
    }



    public function destroy()
    {
        try {

            $userDetail = UserDetail::where('user_id', Auth::user()->id)->first();

            if ($userDetail->image && file_exists(public_path('path/to/images/' .  $userDetail->image))) {
                $this->deleteFile($userDetail->image);
            }
            $userDetail->image = null;
            $userDetail->save();

            // Menampilkan notifikasi sukses
            notyf()->success('Deleted Successfully!');
            return response(['message' => 'Deleted Successfully!'], 200);
        } catch (Exception $e) {
            logger("Merchant Language Error >> " . $e);
            return response(['message' => 'Something went wrong!'], 500);
        }
    }
}
