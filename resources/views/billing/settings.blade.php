@extends('layouts.app')

@section('title', 'Billing Settings - MikroTik RADIUS Management')
@section('page_title', 'Billing Settings')
@section('page_subtitle', 'Configure billing and payment settings')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-cog text-purple-600 dark:text-purple-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Billing Settings</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Billing configuration functionality will be implemented here. Configure payment gateways, billing cycles, and automation settings.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-cog mr-2"></i>
                Configure Settings
            </button>
            <button class="btn-secondary">
                <i class="fas fa-credit-card mr-2"></i>
                Payment Gateways
            </button>
        </div>
    </div>
</div>
@endsection 