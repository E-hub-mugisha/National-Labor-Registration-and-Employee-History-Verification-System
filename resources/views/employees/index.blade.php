@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">

    <h2 class="text-2xl font-bold mb-4">Employees</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('employees.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
        + Add Employee
    </a>

    <div class="bg-white shadow rounded">
        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Name</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr class="border-t">
                        <td class="p-2">
                            {{ $employee->full_name }}
                        </td>
                        <td class="p-2">{{ $employee->email }}</td>
                        <td class="p-2">
                            <span class="px-2 py-1 rounded text-xs {{ $employee->status_badge }}">
                                {{ ucfirst($employee->status) }}
                            </span>
                        </td>
                        <td class="p-2">
                            <a href="{{ route('employees.show', $employee) }}" class="text-blue-600">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $employees->links() }}
    </div>
</div>
@endsection