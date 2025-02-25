@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Merchants Details | {{ $merchant->name }}</h3>
                    <div class="card-actions">
                        <a href="{{ route('admin.merchant.index') }}" class="btn btn-primary">
                            <i class="ti ti-arrow-left"></i>
                            Back
                        </a>
                        <a data-bs-toggle="modal" data-bs-target="#modal-report" aria-haspopup="true" aria-expanded="false"
                            class="btn btn-primary">
                            <i class="ti ti-plus"></i>
                            Add new
                        </a>


                    </div>
                </div>
                <div class="card-body">

                    <!-- Page body -->
                    <div class="page-body">
                        <div class="container-xl">
                            <div class="row row-cards">
                                <div class="col-lg-7">
                                    <div class="">
                                        <div class="table-responsive">
                                            <table class="table table-vcenter card-table">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>Desc</th>
                                                        <th>Type</th>
                                                        <th>Status</th>
                                                        <th>Time</th>
                                                        <th> Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($merchantDetails as  $merchantDetail)
                                                        <tr onclick="window.location='{{ route('admin.merchant.detail', ['merchant' => $merchant->id, 'id' => $merchantDetail->id]) }}'"
                                                            style="cursor:pointer;"
                                                            class="{{ $selectedDetail && $selectedDetail->id == $merchantDetail->id ? 'bg-primary-lt' : '' }}">

                                                            <td class="text-secondary">{{ $loop->iteration }}</td>
                                                            <td class="text-secondary" style="min-width: 110px;">
                                                                {{ \Illuminate\Support\Str::words($merchantDetail->name, 3, '...') }}
                                                            </td>
                                                            <td class="text-secondary" style="min-width: 110px;">
                                                                {{ \Illuminate\Support\Str::words($merchantDetail->desc, 3, '...') }}
                                                            </td>

                                                            <td class="text-secondary">
                                                                {{ $merchantDetail->type }}
                                                            </td>
                                                            <td class="text-secondary" style="min-width: 105px;">
                                                                <div onclick="event.stopPropagation()">
                                                                    <form method="POST"
                                                                        action="{{ route('admin.merchantdetail-status.update') }}"
                                                                        class="status-{{ $merchantDetail->id }}">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $merchantDetail->id }}">
                                                                        <select name="status"
                                                                            class="form-control {{ $merchantDetail->status === '1' ? 'text-green' : 'text-red' }}"
                                                                            onchange="$('.status-{{ $merchantDetail->id }}').submit()">
                                                                            <option @selected($merchantDetail->status === '1')
                                                                                value="1"> Active</option>
                                                                            <option @selected($merchantDetail->status === '0')
                                                                                value="0">Inactive</option>
                                                                        </select>
                                                                    </form>
                                                                </div>
                                                            </td>


                                                            <td class="text-secondary" style="min-width: 150px;">
                                                                Open : {{ $merchantDetail->open }} <br>
                                                                Close : {{ $merchantDetail->close }}
                                                            </td>
                                                            <td>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#create-detail-{{ $merchantDetail->id }}"
                                                                    aria-haspopup="true" aria-expanded="false"
                                                                    class="text-green" onclick="event.stopPropagation();">
                                                                    <i class="ti ti-plus"></i>
                                                                </a>
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#edit-detail-{{ $merchantDetail->id }}"
                                                                    aria-haspopup="true" aria-expanded="false"
                                                                    class="btn-sm btn-primary"
                                                                    onclick="event.stopPropagation();">
                                                                    <i class="ti ti-edit"></i>
                                                                </a>
                                                                <a href="{{ route('admin.merchant.detail.destroy', $merchantDetail->id) }}"
                                                                    class="text-red delete-item"
                                                                    onclick="event.stopPropagation();">
                                                                    <i class="ti ti-trash-x"></i>
                                                                </a>
                                                            </td>
                                                        </tr>


                                                        {{--  // modal edit merchant detail //  --}}
                                                        <div class="modal modal-blur fade"
                                                            id="edit-detail-{{ $merchantDetail->id }}" tabindex="-1"
                                                            role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog  modal-dialog-centered"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <form method="POST"
                                                                        action="{{ route('admin.merchant.detail.update') }}"
                                                                        autocomplete="off" novalidate>
                                                                        @csrf

                                                                        <input type="hidden" name="id"
                                                                            value="{{ $merchantDetail->id }}">
                                                                        <input type="hidden" name="merchant_id"
                                                                            value="{{ $merchantDetail->merchant_id }}">

                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Edit
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">


                                                                            <div class="mb-3">
                                                                                <x-input-block name="name"
                                                                                    :value="$merchantDetail->name"
                                                                                    placeholder="Enter Merchant name" />


                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <x-input-text name="desc"
                                                                                    :value="$merchantDetail->desc"
                                                                                    placeholder="Enter Merchant desc" />
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label
                                                                                    class="form-label text-capitalize">Type</label>
                                                                                <x-select-block name="type"
                                                                                    :value="$merchantDetail->type"
                                                                                    placeholder="Select Type"
                                                                                    :options="[
                                                                                        'indor' => 'Indor',
                                                                                        'outdor' => 'Outdor',
                                                                                    ]" />

                                                                                <x-input-error :messages="$errors->get('type')"
                                                                                    class="mt-2" />
                                                                            </div>


                                                                            <div class="mb-3 row">

                                                                                <div class="col-md-3">
                                                                                    <label
                                                                                        class="form-label text-capitalize">Open</label>
                                                                                    <input type="time"
                                                                                        class="form-control"
                                                                                        name="open" placeholder=""
                                                                                        value="{{ $merchantDetail->open }}">
                                                                                    <x-input-error :messages="$errors->get('open')"
                                                                                        class="mt-2" />
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <label
                                                                                        class="form-label text-capitalize">Close</label>
                                                                                    <input type="time"
                                                                                        class="form-control"
                                                                                        name="close" placeholder=""
                                                                                        value="{{ $merchantDetail->close }}">
                                                                                    <x-input-error :messages="$errors->get('close')"
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

                                                        {{--  // end modal edit merchant detail //  --}}

                                                        {{--  // modal merchant create category //  --}}
                                                        <div class="modal modal-blur fade"
                                                            id="create-detail-{{ $merchantDetail->id }}" tabindex="-1"
                                                            role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog  modal-dialog-centered"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <form method="POST"
                                                                        action="{{ route('admin.merchant.category.store') }}"
                                                                        autocomplete="off" novalidate>
                                                                        @csrf

                                                                        <input type="hidden"
                                                                            value="{{ $merchantDetail->id }}"
                                                                            name="merchant_detail_id">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Create category
                                                                            </h5>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <x-input-block name="name"
                                                                                    placeholder="Enter  name" />
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <x-input-block name="price"
                                                                                    placeholder="Enter Price" />
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

                                                        {{--  // end modal merchant create category //  --}}
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center">No Data Found!</td>
                                                        </tr>
                                                    @endforelse


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="card">
                                        <div class="card-body">
                                            <h3 class="card-title">Price List @if ($selectedDetail)
                                                    | {{ $selectedDetail['name'] }}
                                                @endif
                                            </h3>
                                            <div class="table-responsive">
                                                <table class="table table-vcenter card-table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Name</th>
                                                            <th>Price</th>
                                                            <th> Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @forelse ($detailCategories as  $detailCategorie)
                                                            <tr class="bg-primary-lt">
                                                                <td>{{ $loop->iteration }} </td>
                                                                <td class="text-secondary">
                                                                    {{ $detailCategorie['name'] }}
                                                                </td>
                                                                <td class="text-secondary">
                                                                    {{ $detailCategorie['price'] }}
                                                                </td>

                                                                <td>
                                                                    <a data-bs-toggle="modal"
                                                                        data-bs-target="#edit-category-{{ $detailCategorie->id }}"
                                                                        aria-haspopup="true" aria-expanded="false"
                                                                        class="btn-sm btn-primary">
                                                                        <i class="ti ti-edit"></i>
                                                                    </a>

                                                                    <a href="{{ route('admin.merchant.category.destroy', $detailCategorie->id) }}"
                                                                        class="text-red delete-item">
                                                                        <i class="ti ti-trash-x"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>

                                                            {{--  // modal edit merchant category //  --}}
                                                            <div class="modal modal-blur fade"
                                                                id="edit-category-{{ $detailCategorie->id }}"
                                                                tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog  modal-dialog-centered"
                                                                    role="document">
                                                                    <div class="modal-content">
                                                                        <form method="POST"
                                                                            action="{{ route('admin.merchant.category.update') }}"
                                                                            autocomplete="off" novalidate>
                                                                            @csrf

                                                                            <input type="hidden"
                                                                                value="{{ $detailCategorie->id }}"
                                                                                name="id">

                                                                            <input type="hidden"
                                                                                name="merchant_detail_id"
                                                                                value="{{ $detailCategorie->merchant_detail_id }}">

                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Edit
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">


                                                                                <div class="mb-3">
                                                                                    <x-input-block name="name"
                                                                                        :value="$detailCategorie->name"
                                                                                        placeholder="Enter Merchant name" />
                                                                                </div>

                                                                                <div class="mb-3">
                                                                                    <x-input-block name="price"
                                                                                        :value="$detailCategorie->price"
                                                                                        placeholder="Enter Merchant Price" />
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

                                                            {{--  // end modal edit merchant category //  --}}

                                                        @empty
                                                            <tr>
                                                                <td colspan="4" class="text-center">No Data Found!</td>
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
        </div>
    </div>

    {{--  // create modal merchantt detail //  --}}

    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.merchant.detail.store') }}" autocomplete="off" novalidate>
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Create</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="merchant_id" value="{{ $merchant->id }}">
                        <div class="mb-3">
                            <x-input-block name="name" placeholder="Enter Merchant name" />
                        </div>
                        <div class="mb-3">
                            <x-input-text name="desc" placeholder="Enter Merchant desc" />
                        </div>
                        <div class="mb-3 ">
                            <label class="form-label text-capitalize">Type</label>


                            <x-select-block name="type" placeholder="Select Type" :value="old('type')"
                                :options="[
                                    'indor' => 'Indor',
                                    'outdor' => 'Outdor',
                                ]" />

                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>


                        <div class="mb-3 row">

                            <div class="col-md-3">
                                <label class="form-label text-capitalize">Open</label>
                                <input type="time" class="form-control" name="open" placeholder=""
                                    value="">
                                <x-input-error :messages="$errors->get('open')" class="mt-2" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label text-capitalize">Close</label>
                                <input type="time" class="form-control" name="close" placeholder=""
                                    value="">
                                <x-input-error :messages="$errors->get('close')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                            <i class="ti ti-device-floppy"></i>
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--  // End create modal merchantt detail //  --}}
@endsection
