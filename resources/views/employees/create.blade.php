{{-- resources/views/employees/create.blade.php --}}
@extends('layouts.app')

@section('title', 'New Employee')

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-5 flex items-center gap-2 text-sm text-slate-500">
    <a href="{{ route('employees.index') }}" class="hover:text-blue-600 transition">Employees</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-slate-800 font-medium">New Employee</span>
</nav>

<h1 class="mb-6 text-2xl font-bold text-slate-900">Add New Employee</h1>

<form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
    @csrf
    @include('employees.form')
</form>

@endsection