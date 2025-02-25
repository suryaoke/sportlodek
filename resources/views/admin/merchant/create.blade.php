@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Merchant</h3>
                    <div class="card-actions">
                        <a href="{{ route('admin.merchant.index') }}" class="btn btn-primary">
                            <i class="ti ti-arrow-left"></i>
                            Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.merchant.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-12">
                                <x-input-block name="name" placeholder="Enter Merchant name" />
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label text-capitalize">Merchant</label>
                                <div class="input-group">
                                    <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modal-report" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti ti-plus"></i>
                                    </a>

                                    <x-select-block name="user" placeholder="Select Merchant" :value="old('user')"
                                        :options="$userOptions" />
                                </div>
                                <x-input-error :messages="$errors->get('user')" class="mt-2" />
                            </div>
                            <div class="col-md-12">
                                <x-input-text name="about" placeholder="Enter Merchant About" />
                            </div>
                            <div class="col-md-12">
                                <x-input-text name="address" placeholder="Enter Merchant About" />
                            </div>
                            <div class="col-md-12">
                                <x-input-file-block name="image" />
                            </div>

                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">
                                <i class="ti ti-device-floppy"></i>
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.merchant.akun') }}" autocomplete="off" novalidate>
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Create User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" :value="old('namee')" class="form-control"
                                placeholder="name" autocomplete="off" required>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email address</label>
                            <input type="email" name="email" :value="old('email')" class="form-control"
                                placeholder="your@email.com" autocomplete="off" required>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group input-group-flat">
                                <input type="password" name="password" class="form-control password"
                                    placeholder="Your password" autocomplete="off" required>
                                <span class="input-group-text toggle-password">
                                    <a href="javascript:;" class="link-secondary" title="Show password"
                                        data-bs-toggle="tooltip">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path
                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </a>
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <div class="input-group input-group-flat">
                                <input type="password" name="password_confirmation" class="form-control confirm-password"
                                    placeholder="Your password confirmation" autocomplete="off" required>
                                <span class="input-group-text toggle-confirm-password">
                                    <a href="javascript:;" class="link-secondary" title="Show password"
                                        data-bs-toggle="tooltip">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path
                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                    </a>
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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
@endsection
