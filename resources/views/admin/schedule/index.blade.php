@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Merchants Schedule</h3>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Merchant</th>
                                    <th>About</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($merchants as  $merchant)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="width:20%"><img src="{{ asset($merchant->image) }}" alt=""></td>
                                        <td>{{ $merchant->name }}</td>
                                        <td>{{ $merchant->user->name }}</td>
                                        <td>{{ $merchant->about }}</td>
                                        <td>{{ $merchant->address }}</td>

                                        <td>
                                            <a href="{{ route('admin.schedule.detail', $merchant->id) }}"
                                                class="btn-sm btn-warning text-warning">
                                                <i class="ti ti-list"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No Data Found!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $merchants->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
