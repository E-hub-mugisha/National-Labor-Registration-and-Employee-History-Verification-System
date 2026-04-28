@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 text-center">

    <h2 class="text-2xl font-bold mb-6">Register as</h2>

    <form method="POST" action="{{ route('register.role') }}">
        @csrf

        <div class="grid gap-4">

            <button name="role" value="employer"
                class="p-4 border rounded-lg hover:bg-blue-50">
                🏢 Employer
            </button>

            <button name="role" value="government"
                class="p-4 border rounded-lg hover:bg-green-50">
                🏛 Government
            </button>

            <button name="role" value="admin"
                class="p-4 border rounded-lg hover:bg-gray-50">
                ⚙️ Admin
            </button>

        </div>
    </form>
</div>
@endsection