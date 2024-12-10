@extends('layouts.layout')

@section('title', 'Customer List')

@section('header', 'Customer List')

@section('content')
<a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">Add New Customer</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Billing Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($customers as $customer)
        <tr>
            <td>{{ $customer->id }}</td>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->phone }}</td>
            <td>{{ ucfirst($customer->status) }}</td>
            <td>{{ ucfirst($customer->billing_type) }}</td>
            <td>
                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">No customers found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
