@extends('layouts.app')

@section('title', 'Retail Payment - MikroTik RADIUS Management')
@section('page_title', 'Retail Payment')
@section('page_subtitle', 'Manage retail payment channels')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-store text-orange-600 dark:text-orange-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Retail Payment</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Retail payment integration will be implemented here. Configure payment channels like Indomaret, Alfamart, and other retail partners.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Add Retailer
            </button>
            <button class="btn-secondary">
                <i class="fas fa-chart-bar mr-2"></i>
                View Reports
            </button>
        </div>
    </div>
</div>
@endsection 