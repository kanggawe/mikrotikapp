@extends('layouts.app')

@section('title', 'Export Data - MikroTik RADIUS Management')
@section('page_title', 'Export Data')
@section('page_subtitle', 'Export system data and reports')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-download text-indigo-600 dark:text-indigo-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Export Data</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Data export functionality will be implemented here. Export reports, user data, and system information in various formats.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-file-csv mr-2"></i>
                Export CSV
            </button>
            <button class="btn-secondary">
                <i class="fas fa-file-excel mr-2"></i>
                Export Excel
            </button>
        </div>
    </div>
</div>
@endsection 