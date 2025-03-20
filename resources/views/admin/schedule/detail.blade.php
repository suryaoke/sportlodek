@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Merchants Schedules | {{ $merchant->name }}</h3>
                    <div class="card-actions">
                        <a href="{{ route('admin.merchant.schedule') }}" class="btn btn-primary">
                            <i class="ti ti-arrow-left"></i>
                            Back
                        </a>

                    </div>
                </div>
                <div class="card-body">

                    <!-- Page body -->
                    <div class="page-body">

                        <div class="col-12">
                            <div class="card" style="height: 15rem">
                                <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                                    <div class="divide-y">
                                        <div>
                                            <table class="table table-vcenter card-table">
                                                <thead
                                                    style="position: sticky; top: 0; background-color: white; z-index: 1;">
                                                    <tr>

                                                        <th>Name</th>
                                                        <th>Desc</th>
                                                        <th>Type</th>
                                                        <th>Time</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($merchantDetails as  $merchantDetail)
                                                        <tr onclick="window.location='{{ route('admin.schedule.detail', ['merchant' => $merchant->id, 'id' => $merchantDetail->id]) }}'"
                                                            style="cursor:pointer;"
                                                            class="{{ $selectedDetail && $selectedDetail->id == $merchantDetail->id ? 'bg-primary-lt' : '' }}">


                                                            <td class="text-secondary" style="min-width: 110px;">
                                                                {{ \Illuminate\Support\Str::words($merchantDetail->name, 3, '...') }}
                                                            </td>
                                                            <td class="text-secondary" style="min-width: 110px;">
                                                                {{ \Illuminate\Support\Str::words($merchantDetail->desc, 3, '...') }}
                                                            </td>

                                                            <td class="text-secondary">
                                                                {{ $merchantDetail->type }}
                                                            </td>


                                                            <td class="text-secondary" style="min-width: 150px;">
                                                                Open : {{ $merchantDetail->open }} <br>
                                                                Close : {{ $merchantDetail->close }}
                                                            </td>

                                                        </tr>

                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">No Data Found!</td>
                                                        </tr>
                                                    @endforelse


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="card mt-5">
                            <div class="row g-0">
                                <div class="col-12 col-md-6 border-end">
                                    <div class="card" style="height: 15rem">
                                        <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                                            <h3 class="card-title">Price List @if ($selectedDetail)
                                                    | {{ $selectedDetail['name'] }}
                                                @endif
                                            </h3>
                                            <div class="divide-y">
                                                <div>
                                                    <table class="table table-vcenter card-table">
                                                        <thead>
                                                            <thead
                                                                style="position: sticky; top: 0; background-color: white; z-index: 1;">
                                                                <th>Name</th>
                                                                <th>Price / Hour</th>
                                                                <th> Action</th>
                                                                </tr>
                                                            </thead>
                                                        <tbody>

                                                            @forelse ($detailCategories as  $detailCategorie)
                                                                <tr onclick="window.location='{{ route('admin.schedule.detail', [
                                                                    'merchant' => $merchant->id,
                                                                    'id' => $selectedDetail ? $selectedDetail->id : null,
                                                                    'scheduleId' => $detailCategorie->id,
                                                                ]) }}'"
                                                                    style="cursor:pointer;"
                                                                    class="{{ $selectedSchedule && $selectedSchedule->id == $detailCategorie->id ? 'bg-primary-lt' : '' }}">


                                                                    <td class="text-secondary">
                                                                        {{ $detailCategorie['name'] }}
                                                                    </td>
                                                                    <td class="text-secondary">
                                                                        {{ number_format($detailCategorie['price'], 0, ',', '.') }}
                                                                    </td>

                                                                    <td>
                                                                        <a data-bs-toggle="modal"
                                                                            data-bs-target="#createschedule-{{ $detailCategorie->id }}"
                                                                            aria-haspopup="true" aria-expanded="false"
                                                                            class="text-green"
                                                                            onclick="event.stopPropagation();">
                                                                            <i class="ti ti-plus"></i>
                                                                        </a>


                                                                    </td>
                                                                </tr>

                                                                {{--  // modal create schedule //  --}}
                                                                <div class="modal modal-blur fade"
                                                                    id="createschedule-{{ $detailCategorie->id }}"
                                                                    tabindex="-1" role="dialog" aria-hidden="true">
                                                                    <div class="modal-dialog  modal-dialog-centered"
                                                                        role="document">
                                                                        <div class="modal-content">
                                                                            <form method="POST"
                                                                                action="{{ route('admin.schedule.store') }}"
                                                                                autocomplete="off" novalidate>
                                                                                @csrf

                                                                                <input type="hidden"
                                                                                    value="{{ $detailCategorie->id }}"
                                                                                    name="merchant_detail_category_id">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Create
                                                                                    </h5>
                                                                                    <button type="button" class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <div class="mb-3">
                                                                                        <x-input-block name="name"
                                                                                            placeholder="Enter Merchant name" />
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label
                                                                                            class="form-label text-capitalize">Date</label>
                                                                                        <div class="input-icon">
                                                                                            <span
                                                                                                class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                    class="icon"
                                                                                                    width="24"
                                                                                                    height="24"
                                                                                                    viewBox="0 0 24 24"
                                                                                                    stroke-width="2"
                                                                                                    stroke="currentColor"
                                                                                                    fill="none"
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round">
                                                                                                    <path stroke="none"
                                                                                                        d="M0 0h24v24H0z"
                                                                                                        fill="none" />
                                                                                                    <path
                                                                                                        d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                                                                    <path d="M16 3v4" />
                                                                                                    <path d="M8 3v4" />
                                                                                                    <path d="M4 11h16" />
                                                                                                    <path d="M11 15h1" />
                                                                                                    <path d="M12 15v3" />
                                                                                                </svg>
                                                                                            </span>
                                                                                            <input class="form-control"
                                                                                                placeholder="Select a date"
                                                                                                id="datepicker-icon-prepend"
                                                                                                name="date"
                                                                                                value="{{ \Carbon\Carbon::now()->toDateString() }}" />

                                                                                        </div>
                                                                                    </div>

                                                                                </div>

                                                                                <div class="modal-footer">
                                                                                    <a href="#"
                                                                                        class="btn btn-link link-secondary"
                                                                                        data-bs-dismiss="modal">
                                                                                        Cancel
                                                                                    </a>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary ms-auto"
                                                                                        data-bs-dismiss="modal">
                                                                                        <i class="ti ti-device-floppy"></i>
                                                                                        Create
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{--  // end modal create schedule //  --}}

                                                            @empty
                                                                <tr>
                                                                    <td colspan="4" class="text-center">No Data Found!
                                                                    </td>
                                                                </tr>
                                                            @endforelse


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 d-flex flex-column">
                                    <div class="card" style="height: 15rem">
                                        <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                                            <h3 class="card-title">Date Schedule
                                                @if ($selectedDetail)
                                                    |
                                                    {{ $selectedDetail['name'] }}
                                                @endif
                                                @if ($selectedSchedule)
                                                    |{{ $selectedSchedule['name'] }}
                                                @endif
                                            </h3>
                                            <div class="divide-y">
                                                <div>
                                                    <table class="table table-vcenter card-table">
                                                        <thead>
                                                            <thead
                                                                style="position: sticky; top: 0; background-color: white; z-index: 1;">

                                                                <th>Name</th>
                                                                <th>Date</th>
                                                                <th>Action</th>

                                                                </tr>
                                                            </thead>
                                                        <tbody>
                                                            @forelse ($schedules as  $schedule)
                                                                <tr onclick="window.location='{{ route('admin.schedule.detail', [
                                                                    'merchant' => $merchant->id,
                                                                    'id' => $selectedDetail ? $selectedDetail->id : null,
                                                                    'scheduleId' => $selectedSchedule ? $selectedSchedule->id : null,
                                                                    'scheduleDetailId' => $schedule->id,
                                                                ]) }}'"
                                                                    style="cursor:pointer;"
                                                                    class="{{ $selectedScheduleDetail && $selectedScheduleDetail->id == $schedule->id ? 'bg-primary-lt' : '' }}">


                                                                    <td class="text-secondary" style="min-width: 110px;">
                                                                        {{ \Illuminate\Support\Str::words($schedule->name, 3, '...') }}
                                                                    </td>
                                                                    <td class="text-secondary" style="min-width: 110px;">
                                                                        {{ $schedule->date }}
                                                                    </td>



                                                                    <td>
                                                                        <a data-bs-toggle="modal"
                                                                            data-bs-target="#createschedule-detail-{{ $schedule->id }}"
                                                                            aria-haspopup="true" aria-expanded="false"
                                                                            class="text-green"
                                                                            onclick="event.stopPropagation();">
                                                                            <i class="ti ti-plus"></i>
                                                                        </a>
                                                                        <a data-bs-toggle="modal"
                                                                            data-bs-target="#editschedule-{{ $schedule->id }}"
                                                                            aria-haspopup="true" aria-expanded="false"
                                                                            class="btn-sm btn-primary"
                                                                            onclick="event.stopPropagation();">
                                                                            <i class="ti ti-edit"></i>
                                                                        </a>
                                                                        <a href="{{ route('admin.schedule.destroy', $schedule->id) }}"
                                                                            class="text-red delete-item"
                                                                            onclick="event.stopPropagation();">
                                                                            <i class="ti ti-trash-x"></i>
                                                                        </a>
                                                                    </td>

                                                                </tr>

                                                                {{--  // modal create schedule Detail //  --}}
                                                                <div class="modal modal-blur fade"
                                                                    id="createschedule-detail-{{ $schedule->id }}"
                                                                    tabindex="-1" role="dialog" aria-hidden="true">
                                                                    <div class="modal-dialog  modal-dialog-centered"
                                                                        role="document">
                                                                        <div class="modal-content">
                                                                            <form method="POST"
                                                                                action="{{ route('admin.schedule.detail.store') }}"
                                                                                autocomplete="off" novalidate>
                                                                                @csrf

                                                                                <input type="hidden"
                                                                                    value="{{ $schedule->id }}"
                                                                                    name="schedule_id">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Create
                                                                                    </h5>
                                                                                    <button type="button"
                                                                                        class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">


                                                                                    <div class="mb-3 row">

                                                                                        <div class="col-md-3">
                                                                                            <label
                                                                                                class="form-label text-capitalize">In</label>
                                                                                            <input type="time"
                                                                                                class="form-control"
                                                                                                name="in"
                                                                                                placeholder="">
                                                                                            <x-input-error :messages="$errors->get(
                                                                                                'in',
                                                                                            )"
                                                                                                class="mt-2" />
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <label
                                                                                                class="form-label text-capitalize">Out</label>
                                                                                            <input type="time"
                                                                                                class="form-control"
                                                                                                name="out"
                                                                                                placeholder="">
                                                                                            <x-input-error :messages="$errors->get(
                                                                                                'out',
                                                                                            )"
                                                                                                class="mt-2" />
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <x-input-block name="date"
                                                                                                value=" {{ $schedule->date }}"
                                                                                                placeholder="Enter Merchant name"
                                                                                                readonly />

                                                                                        </div>
                                                                                    </div>


                                                                                </div>

                                                                                <div class="modal-footer">
                                                                                    <a href="#"
                                                                                        class="btn btn-link link-secondary"
                                                                                        data-bs-dismiss="modal">
                                                                                        Cancel
                                                                                    </a>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary ms-auto"
                                                                                        data-bs-dismiss="modal">
                                                                                        <i class="ti ti-device-floppy"></i>
                                                                                        Create
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{--  // end modal create schedule detail//  --}}

                                                                {{--  // modal edit schedule  //  --}}
                                                                <div class="modal modal-blur fade"
                                                                    id="editschedule-{{ $schedule->id }}" tabindex="-1"
                                                                    role="dialog" aria-hidden="true">
                                                                    <div class="modal-dialog  modal-dialog-centered"
                                                                        role="document">
                                                                        <div class="modal-content">
                                                                            <form method="POST"
                                                                                action="{{ route('admin.schedule.update') }}"
                                                                                autocomplete="off" novalidate>
                                                                                @csrf

                                                                                <input type="hidden"
                                                                                    value="{{ $schedule->id }}"
                                                                                    name="id">

                                                                                <input type="hidden"
                                                                                    value="{{ $schedule->merchant_detail_category_id }}"
                                                                                    name="merchant_detail_category_id">

                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Edit
                                                                                    </h5>
                                                                                    <button type="button"
                                                                                        class="btn-close"
                                                                                        data-bs-dismiss="modal"
                                                                                        aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">

                                                                                    <div class="mb-3">
                                                                                        <x-input-block name="name"
                                                                                            value="{{ $schedule->name }}"
                                                                                            placeholder="Enter Merchant name" />
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label
                                                                                            class="form-label text-capitalize">Date</label>
                                                                                        <div class="input-icon">
                                                                                            <span
                                                                                                class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                    class="icon"
                                                                                                    width="24"
                                                                                                    height="24"
                                                                                                    viewBox="0 0 24 24"
                                                                                                    stroke-width="2"
                                                                                                    stroke="currentColor"
                                                                                                    fill="none"
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round">
                                                                                                    <path stroke="none"
                                                                                                        d="M0 0h24v24H0z"
                                                                                                        fill="none" />
                                                                                                    <path
                                                                                                        d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                                                                    <path d="M16 3v4" />
                                                                                                    <path d="M8 3v4" />
                                                                                                    <path d="M4 11h16" />
                                                                                                    <path d="M11 15h1" />
                                                                                                    <path d="M12 15v3" />
                                                                                                </svg>
                                                                                            </span>
                                                                                            <input class="form-control"
                                                                                                placeholder="Select a date"
                                                                                                id="datepicker-icon-prepend"
                                                                                                name="date"
                                                                                                value="{{ $schedule->date }}" />

                                                                                        </div>
                                                                                    </div>



                                                                                </div>

                                                                                <div class="modal-footer">
                                                                                    <a href="#"
                                                                                        class="btn btn-link link-secondary"
                                                                                        data-bs-dismiss="modal">
                                                                                        Cancel
                                                                                    </a>
                                                                                    <button type="submit"
                                                                                        class="btn btn-primary ms-auto"
                                                                                        data-bs-dismiss="modal">
                                                                                        <i class="ti ti-device-floppy"></i>
                                                                                        Update
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{--  // end modal edit schedule //  --}}
                                                            @empty
                                                                <tr>
                                                                    <td colspan="4" class="text-center">No Data Found!
                                                                    </td>
                                                                </tr>
                                                            @endforelse


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        {{--  //schedule //  --}}


                        <div class="col-12 mt-5">
                            <div class="card" style="height: 30rem">
                                <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                                    <h3 class="card-title">List Of Schedule @if ($selectedDetail)
                                            |
                                            {{ $selectedDetail['name'] }}
                                        @endif
                                        @if ($selectedSchedule)
                                            |{{ $selectedSchedule['name'] }}
                                        @endif
                                        @if ($selectedScheduleDetail)
                                            |
                                            {{ $selectedScheduleDetail['name'] }}
                                            | {{ $selectedScheduleDetail['date'] }}
                                        @endif
                                    </h3>

                                    <div class="divide-y">
                                        <div>
                                            <table class="table table-vcenter card-table">
                                                <thead
                                                    style="position: sticky; top: 0; background-color: white; z-index: 1;">
                                                    <tr>

                                                        <th>In</th>
                                                        <th>Out</th>
                                                        <th>Status</th>
                                                        <th> Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @forelse ($scheduleDetails as  $scheduleDetail)
                                                        <tr class="bg-primary-lt">

                                                            <td class="text-secondary">
                                                                {{ $scheduleDetail['in'] }}
                                                            </td>
                                                            <td class="text-secondary">
                                                                {{ $scheduleDetail['out'] }}
                                                            </td>
                                                            <td class="text-secondary">
                                                                @if ($scheduleDetail['status'] === '1')
                                                                    <div class="text-green">
                                                                        Available
                                                                    </div>
                                                                @elseif($scheduleDetail['status'] === '0')
                                                                    <div class="text-red">
                                                                        Booked
                                                                    </div>
                                                                @endif

                                                            </td>

                                                            <td>

                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#editschedule-detail-{{ $scheduleDetail->id }}"
                                                                    aria-haspopup="true" aria-expanded="false"
                                                                    class="btn-sm btn-primary"
                                                                    onclick="event.stopPropagation();">
                                                                    <i class="ti ti-edit"></i>
                                                                </a>
                                                                <a href="{{ route('admin.schedule.detail.destroy', $scheduleDetail->id) }}"
                                                                    class="text-red delete-item"
                                                                    onclick="event.stopPropagation();">
                                                                    <i class="ti ti-trash-x"></i>
                                                                </a>
                                                            </td>
                                                        </tr>

                                                        {{--  // modal edit schedule edit //  --}}
                                                        <div class="modal modal-blur fade"
                                                            id="editschedule-detail-{{ $scheduleDetail->id }}"
                                                            tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog  modal-dialog-centered"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <form method="POST"
                                                                        action="{{ route('admin.schedule.detail.update') }}"
                                                                        autocomplete="off" novalidate>
                                                                        @csrf


                                                                        <input type="hidden"
                                                                            value="{{ $scheduleDetail->id }}"
                                                                            name="id">

                                                                        <input type="hidden"
                                                                            value="{{ $scheduleDetail->schedule_id }}"
                                                                            name="schedule_id">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Edit
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">

                                                                            <div class="mb-3 row">

                                                                                <div class="col-md-3">
                                                                                    <label
                                                                                        class="form-label text-capitalize">In</label>
                                                                                    <input type="time"
                                                                                        class="form-control"
                                                                                        name="in"
                                                                                        value="{{ $scheduleDetail->in }}"
                                                                                        placeholder="">
                                                                                    <x-input-error :messages="$errors->get('in')"
                                                                                        class="mt-2" />
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <label
                                                                                        class="form-label text-capitalize">Out</label>
                                                                                    <input type="time"
                                                                                        class="form-control"
                                                                                        name="out"
                                                                                        value="{{ $scheduleDetail->out }}"
                                                                                        placeholder="">
                                                                                    <x-input-error :messages="$errors->get('out')"
                                                                                        class="mt-2" />
                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <a href="#"
                                                                                class="btn btn-link link-secondary"
                                                                                data-bs-dismiss="modal">
                                                                                Cancel
                                                                            </a>
                                                                            <button type="submit"
                                                                                class="btn btn-primary ms-auto"
                                                                                data-bs-dismiss="modal">
                                                                                <i class="ti ti-device-floppy"></i>
                                                                                Update
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{--  // end modal edit schedule edit //  --}}

                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center">No Data
                                                                Found!</td>
                                                        </tr>
                                                    @endforelse


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    @endsection
