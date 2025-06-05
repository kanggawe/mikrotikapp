@extends('layouts.app')

@section('title', 'Test Page')
@section('page_title', 'Test')
@section('page_subtitle', 'Testing section structure')

@section('content')
<div class="content-section p-8">
    <h1>Test Page</h1>
    <p>This is a test page to verify section structure.</p>
</div>
@endsection

@push('scripts')
<script>
    console.log('Test script');
</script>
@endpush 