@extends('admin.layouts.master')

@section('content')
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-md-3 border-end">
                        <div class="card-body">
                            <h4 class="subheader">Profile</h4>
                            <div class="list-group list-group-transparent">
                                <a href="{{ route('admin.profile') }}"
                                    class="list-group-item list-group-item-action d-flex align-items-center ">My
                                    Account</a>

                            </div>

                            <div class="list-group list-group-transparent">
                                <a href="{{ route('admin.password') }}"
                                    class="list-group-item list-group-item-action d-flex align-items-center active">Update
                                    Password
                                </a>

                            </div>

                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')
                            <div class="card-body">

                                <h3 class="card-title mt-4">Current Password</h3>

                                <div>

                                    <div class="input-group input-group-flat">
                                        <input type="password" id="update_password_current_password"
                                            name="current_password"" class="form-control password"
                                            placeholder="Your current password" autocomplete="current-password" required>
                                        <span class="input-group-text toggle-password">
                                            <a href="javascript:;" class="link-secondary" title="Show password"
                                                data-bs-toggle="tooltip">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path
                                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                </svg>
                                            </a>
                                        </span>
                                    </div>
                                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                                </div>

                                <h3 class="card-title mt-4">New Password</h3>

                                <div>
                                    <div class="input-group input-group-flat">
                                        <input type="password" name="password" class="form-control confirm-password"
                                            placeholder="Your new password" autocomplete="new-password" required>
                                        <span class="input-group-text toggle-confirm-password">
                                            <a href="javascript:;" class="link-secondary" title="Show password"
                                                data-bs-toggle="tooltip">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path
                                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                </svg>
                                            </a>
                                        </span>
                                    </div>
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                </div>
                                <h3 class="card-title mt-4">Confirm Password</h3>

                                <div>
                                    <div class="input-group input-group-flat">
                                        <input type="password" name="password_confirmation"
                                            id="update_password_password_confirmation" class="form-control confirm-password"
                                            placeholder="Your confirmation password " autocomplete="new-password" required>
                                        <span class="input-group-text toggle-confirm-password">
                                            <a href="javascript:;" class="link-secondary" title="Show password"
                                                data-bs-toggle="tooltip">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path
                                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                </svg>
                                            </a>
                                        </span>
                                    </div>
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                </div>

                            </div>
                            <div class="card-footer bg-transparent mt-auto">
                                <div class="btn-list justify-content-end">
                                    <a href="{{ route('admin.dashboard') }}" class="btn">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        Save
                                    </button>

                                    @if (session('status') === 'password-updated')
                                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
