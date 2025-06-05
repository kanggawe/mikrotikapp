@extends('layouts.app')

@section('title', 'Invoice Management - MikroTik RADIUS Management')
@section('page_title', 'Invoice Management')
@section('page_subtitle', 'Manage customer invoices and billing')

@section('content')
<div class="content-section p-8">
    <div class="text-center">
        <div class="w-24 h-24 mx-auto bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-file-invoice text-green-600 dark:text-green-400 text-4xl"></i>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Invoice Management</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">
            Invoice management system will be implemented here. Generate, send, and track customer invoices and billing statements.
        </p>
        <div class="flex justify-center space-x-4">
            <button class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Create Invoice
            </button>
            <button class="btn-secondary">
                <i class="fas fa-file-pdf mr-2"></i>
                Export PDF
            </button>
        </div>
    </div>
</div>
@endsection 