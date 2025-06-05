@extends('layouts.app')

@section('title', 'System Logs - MikroTik RADIUS Management')
@section('page_title', 'System Logs')
@section('page_subtitle', 'Monitor system logs and events')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-file-alt text-gray-600 dark:text-gray-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">System Logs</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            System log monitoring will be implemented here. View real-time logs, filter events, and analyze system behavior.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-eye mr-2"></i>
                View Logs
            </button>
            <button class="btn-secondary">
                <i class="fas fa-download mr-2"></i>
                Export Logs
            </button>
        </div>
    </div>
</div>
@endsection 