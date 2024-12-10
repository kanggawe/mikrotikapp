@extends('layouts.layout')

@section('title', 'Add New Customer')

@section('header', 'Add New Customer')

@section('content')
<form action="{{ route('customers.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" name="address" id="address" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="free">Free</option>
        </select>
    </div>
    <div class="form-group">
        <label for="billing_type">Billing Type</label>
        <select name="billing_type" id="billing_type" class="form-control" required>
            <option value="prepaid">Prepaid</option>
            <option value="postpaid">Postpaid</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Add Customer</button>
</form>
@endsection
