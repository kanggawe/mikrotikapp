@extends('layouts.app')

@section('title', 'WhatsApp Integration - MikroTik RADIUS Management')
@section('page_title', 'WhatsApp Integration')
@section('page_subtitle', 'Manage WhatsApp notifications and messaging')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mb-6">
            <i class="fab fa-whatsapp text-green-600 dark:text-green-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">WhatsApp Integration</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            WhatsApp messaging integration will be implemented here. Send notifications, alerts, and customer communications via WhatsApp.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-cog mr-2"></i>
                Configure API
            </button>
            <button class="btn-secondary">
                <i class="fas fa-paper-plane mr-2"></i>
                Send Message
            </button>
        </div>
    </div>
</div>
@endsection 