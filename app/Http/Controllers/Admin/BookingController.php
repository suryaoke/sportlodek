<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\MerchantDetail;
use App\Models\MerchantDetailCategory;
use App\Models\Schedule;
use App\Models\ScheduleDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(): View
    {
        $merchants = Merchant::paginate(10);
        return view('admin.booking.index', compact('merchants'));
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
            ? Schedule::where('merchant_detail_category_id', $selectedSchedule->id)
            ->orderBy('date', 'desc')
            ->get()
            : collect(); // jika tidak ada data, kembalikan collection kosong



        $selectedScheduleDetail = $scheduleDetailId ? Schedule::find($scheduleDetailId) : null;


        $scheduleDetails = $selectedScheduleDetail
            ? ScheduleDetail::where('schedule_id', $selectedScheduleDetail->id)->get()
            : collect(); // jika tidak ada data, kembalikan collection kosong


        return view('admin.booking.detail', compact('selectedScheduleDetail', 'scheduleDetails', 'selectedScheduleDetail', 'schedules', 'detailCategories', 'merchant', 'merchantDetails', 'selectedDetail', 'selectedSchedule'));
    }
}
