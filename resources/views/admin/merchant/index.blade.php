@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Merchants</h3>
                    <div class="card-actions">
                        <a href="{{ route('admin.merchant.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus"></i>
                            Add new
                        </a>
                    </div>
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
                                            <a href="{{ route('admin.merchant.detail', $merchant->id) }}"
                                                class="btn-sm btn-warning text-warning">
                                                <i class="ti ti-list"></i>
                                            </a>
                                            <a href="{{ route('admin.merchant.edit', $merchant->id) }}"
                                                class="btn-sm btn-primary">
                                                <i class="ti ti-edit"></i>
                                            </a>

                                            <a href="{{ route('admin.merchant.destroy', $merchant->id) }}"
                                                class="text-red delete-item">
                                                <i class="ti ti-trash-x"></i>
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
