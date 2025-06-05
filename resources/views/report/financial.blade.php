@extends('layouts.app')

@section('title', 'Financial Report - MikroTik RADIUS Management')
@section('page_title', 'Financial Report')
@section('page_subtitle', 'Monitor revenue and financial analytics')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-file-alt text-green-600 dark:text-green-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Financial Report</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Financial reporting functionality will be implemented here. Track revenue, expenses, profit margins, and financial trends.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-chart-pie mr-2"></i>
                Generate Report
            </button>
            <button class="btn-secondary">
                <i class="fas fa-file-pdf mr-2"></i>
                Export PDF
            </button>
        </div>
    </div>
</div>
@endsection 