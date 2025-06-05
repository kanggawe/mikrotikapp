@extends('layouts.app')

@section('title', 'Bank Transfer - MikroTik RADIUS Management')
@section('page_title', 'Bank Transfer')
@section('page_subtitle', 'Manage bank transfer payment channels')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-credit-card text-green-600 dark:text-green-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Bank Transfer</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Bank transfer payment system will be implemented here. Configure bank accounts, manage transfers, and automate payment verification.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Add Bank Account
            </button>
            <button class="btn-secondary">
                <i class="fas fa-check mr-2"></i>
                Verify Payments
            </button>
        </div>
    </div>
</div>
@endsection 