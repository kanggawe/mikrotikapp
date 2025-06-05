@extends('layouts.app')

@section('title', 'Authentication Logs - MikroTik RADIUS Management')
@section('page_title', 'Authentication Logs')
@section('page_subtitle', 'Monitor RADIUS authentication attempts and events')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-yellow-100 dark:bg-yellow-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-history text-yellow-600 dark:text-yellow-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Authentication Logs</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Authentication log monitoring will be implemented here. Track login attempts, authentication failures, and security events.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-eye mr-2"></i>
                View Logs
            </button>
            <button class="btn-secondary">
                <i class="fas fa-filter mr-2"></i>
                Filter Events
            </button>
        </div>
    </div>
</div>
@endsection 