@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Update Category</h3>
                    <div class="card-actions">
                        <a href="{{ route('admin.merchant.index') }}" class="btn btn-primary">
                            <i class="ti ti-arrow-left"></i>
                            Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.merchant.update', $merchant->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <x-image-preview src="{{ asset($merchant->image) }}" />

                            <div class="col-md-12">
                                <x-input-file-block name="image" />
                            </div>

                            <div class="col-md-12">
                                <x-input-block name="name" :value="$merchant->name" placeholder="Enter Merchant Name" />
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label text-capitalize">Merchant</label>
                                <x-select-block name="user" placeholder="Select Merchant" :value="$merchant->user_id"
                                    :options="$userOptions" />

                                <x-input-error :messages="$errors->get('user')" class="mt-2" />
                            </div>

                            <div class="col-md-12">
                                <x-input-text name="about" :value="$merchant->about" placeholder="Enter Merchant About" />
                            </div>

                            <div class="col-md-12">
                                <x-input-text name="address" :value="$merchant->address" placeholder="Enter Merchant Address" />
                            </div>



                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">
                                <i class="ti ti-device-floppy"></i>
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
