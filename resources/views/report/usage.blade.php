@extends('layouts.app')

@section('title', 'Usage Report - MikroTik RADIUS Management')
@section('page_title', 'Usage Report')
@section('page_subtitle', 'Monitor bandwidth and service usage analytics')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-chart-line text-blue-600 dark:text-blue-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Usage Report</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Usage reporting functionality will be implemented here. Monitor bandwidth usage, session analytics, and user activity patterns.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-chart-line mr-2"></i>
                Generate Report
            </button>
            <button class="btn-secondary">
                <i class="fas fa-download mr-2"></i>
                Export Data
            </button>
        </div>
    </div>
</div>
@endsection 