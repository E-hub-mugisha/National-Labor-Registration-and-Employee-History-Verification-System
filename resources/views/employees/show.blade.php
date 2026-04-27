@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">

    <h2 class="text-2xl font-bold mb-4">
        {{ $employee->full_name }}
    </h2>

    <div class="bg-white shadow p-4 rounded">

        <p><strong>Email:</strong> {{ $employee->email }}</p>
        <p><strong>Phone:</strong> {{ $employee->phone }}</p>
        <p><strong>National ID:</strong> {{ $employee->national_id }}</p>
        <p><strong>Status:</strong> {{ $employee->status }}</p>
        <p><strong>Employer:</strong> {{ $employee->currentEmployer->name ?? '-' }}</p>

    </div>

</div>
@endsection