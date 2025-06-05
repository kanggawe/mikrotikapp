@extends('layouts.app')

@section('title', 'E-Wallet Payments - MikroTik RADIUS Management')
@section('page_title', 'E-Wallet Payments')
@section('page_subtitle', 'Manage digital wallet payment channels')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-mobile-alt text-blue-600 dark:text-blue-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">E-Wallet Payments</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            E-wallet payment integration will be implemented here. Configure and manage digital wallet payment channels like GoPay, OVO, DANA, etc.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Add E-Wallet
            </button>
            <button class="btn-secondary">
                <i class="fas fa-cog mr-2"></i>
                Settings
            </button>
        </div>
    </div>
</div>
@endsection 