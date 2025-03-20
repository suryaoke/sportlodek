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
                                    class="list-group-item list-group-item-action d-flex align-items-center active">My
                                    Account</a>

                            </div>

                            <div class="list-group list-group-transparent">
                                <a href="{{ route('admin.password') }}"
                                    class="list-group-item list-group-item-action d-flex align-items-center">Update
                                    Password
                                </a>

                            </div>

                        </div>
                    </div>
                    <div class="col-12 col-md-9 d-flex flex-column">
                        <div class="card-body">
                            <h3 class="card-title">Profile Details</h3>
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <span class="avatar avatar-xl"
                                        style="background-image: url({{ $userDetail->image ? asset($userDetail->image) : asset('admin/assets/static/avatars/userprofile.jpg') }})">
                                    </span>
                                </div>



                                <div class="col-auto">
                                    <form id="imageForm" action="{{ route('admin.profile.store.image') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-auto">
                                            <button type="button" class="btn" id="changeImageBtn">Change</button>
                                            <input type="file" id="imageInput" name="image" style="display: none;"
                                                accept="image/*">
                                        </div>
                                    </form>

                                </div>

                                @if ($userDetail->image != null)
                                    <div class="col-auto"><a href="{{ route('admin.profile.delete') }}"
                                            class="btn btn-ghost-danger delete-item">
                                            Delete
                                        </a></div>
                                @endif

                            </div>

                            <form method="post" action="{{ route('admin.profile.update') }}">
                                @csrf
                                @method('patch')
                                <div class="row g-3 mt-4">
                                    <div class="col-md">
                                        <div class="form-label">Name</div>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ Auth::user()->name }}">
                                    </div>
                                    <div class="col-md">
                                        <div class="form-label">Phone</div>
                                        <input type="number" class="form-control" name="phone"
                                            value="{{ Auth::user()->userDetail->phone ?? '-' }}">

                                    </div>
                                    <div class="col-md">
                                        <div class="form-label">Address</div>
                                        <input type="text" class="form-control" name="address"
                                            value="{{ Auth::user()->userDetail->address ?? '-' }}">
                                    </div>
                                </div>


                                <h3 class="card-title mt-4">Email</h3>

                                <div>
                                    <div class="row g-2">
                                        <div class="col-auto">
                                            <input type="email" class="form-control w-auto" name="email"
                                                value="{{ Auth::user()->email }}">
                                        </div>

                                    </div>
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
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('changeImageBtn').addEventListener('click', function() {
            document.getElementById('imageInput').click();
        });

        document.getElementById('imageInput').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                // Setelah pilih file, Anda bisa mengirim form secara otomatis
                document.getElementById('imageForm').submit();
            }
        });
    </script>
@endsection
