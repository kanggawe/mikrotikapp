@extends('layouts.app')

@section('title', 'PPP Accounting - MikroTik RADIUS Management')
@section('page_title', 'PPP Accounting')
@section('page_subtitle', 'Monitor PPP session accounting and usage')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-chart-bar text-green-600 dark:text-green-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">PPP Accounting</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            PPP accounting system will be implemented here. Monitor session data, bandwidth usage, and connection statistics.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-chart-line mr-2"></i>
                View Reports
            </button>
            <button class="btn-secondary">
                <i class="fas fa-download mr-2"></i>
                Export Data
            </button>
        </div>
    </div>
</div>
@endsection 