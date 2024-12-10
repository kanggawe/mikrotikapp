@extends('layouts.layout')

@section('title', 'Edit Customer')

@section('header', 'Edit Customer')

@section('content')
<form action="{{ route('customers.update', $customer->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ $customer->name }}" required>
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" name="address" id="address" class="form-control" value="{{ $customer->address }}" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control" value="{{ $customer->phone }}" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ $customer->email }}" required>
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $customer->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="free" {{ $customer->status == 'free' ? 'selected' : '' }}>Free</option>
        </select>
    </div>
    <div class="form-group">
        <label for="billing_type">Billing Type</label>
        <select name="billing_type" id="billing_type" class="form-control" required>
            <option value="prepaid" {{ $customer->billing_type == 'prepaid' ? 'selected' : '' }}>Prepaid</option>
            <option value="postpaid" {{ $customer->billing_type == 'postpaid' ? 'selected' : '' }}>Postpaid</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update Customer</button>
</form>
@endsection
