@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Merchants Booking | {{ $merchant->name }}</h3>
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
                                                        <tr onclick="window.location='{{ route('admin.schedule.detail.booking', ['merchant' => $merchant->id, 'id' => $merchantDetail->id]) }}'"
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
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Price / Hour</th>

                                                                </tr>
                                                            </thead>
                                                        <tbody>

                                                            @forelse ($detailCategories as  $detailCategorie)
                                                                <tr onclick="window.location='{{ route('admin.schedule.detail.booking', [
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


                                                                </tr>



                                                            @empty
                                                                <tr>
                                                                    <td colspan="2" class="text-center">No Data Found!
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
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Date</th>


                                                                </tr>
                                                            </thead>
                                                        <tbody>
                                                            @forelse ($schedules as  $schedule)
                                                                <tr onclick="window.location='{{ route('admin.schedule.detail.booking', [
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





                                                                </tr>

                                                            @empty
                                                                <tr>
                                                                    <td colspan="2" class="text-center">No Data Found!
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
                                                                    class="text-red" onclick="event.stopPropagation();">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                        width="48" height="48" viewBox="0 0 24 24"
                                                                        stroke-width="2" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M4 18v-9.5a4.5 4.5 0 0 1 4.5 -4.5h7a4.5 4.5 0 0 1 4.5 4.5v7a4.5 4.5 0 0 1 -4.5 4.5h-9.5a2 2 0 0 1 -2 -2z" />
                                                                        <path
                                                                            d="M8 12h3.5a2 2 0 1 1 0 4h-3.5v-7a1 1 0 0 1 1 -1h1.5a2 2 0 1 1 0 4h-1.5" />
                                                                        <path d="M16 16l.01 0" />
                                                                    </svg>
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
                                                                    <form method="POST" action=""
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
