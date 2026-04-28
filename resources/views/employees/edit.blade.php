{{-- resources/views/employees/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit · ' . $employee->full_name)

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-5 flex items-center gap-2 text-sm text-slate-500">
    <a href="{{ route('employees.index') }}" class="hover:text-blue-600 transition">Employees</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
    </svg>
    <a href="{{ route('employees.show', $employee) }}" class="hover:text-blue-600 transition">{{ $employee->full_name }}</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-slate-800 font-medium">Edit</span>
</nav>

<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-900">Edit Employee</h1>
    <span class="badge {{ $employee->status_badge }}">{{ ucfirst($employee->status) }}</span>
</div>

<form method="POST" action="{{ route('employees.update', $employee) }}" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('employees.form')
</form>

@endsection