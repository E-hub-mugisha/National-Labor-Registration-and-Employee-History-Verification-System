@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10">

    <h2 class="text-2xl font-bold mb-6">Employer Registration</h2>

    <form method="POST" action="{{ route('register.employer.store') }}">
        @csrf

        <div class="grid grid-cols-2 gap-4">

            <input name="company_name" placeholder="Company Name" class="border p-2">

            <input name="email" type="email" placeholder="Email" class="border p-2">

            <input name="phone" placeholder="Phone" class="border p-2">

            <input name="tin_number" placeholder="TIN Number" class="border p-2">

            <input name="registration_number" placeholder="Registration Number" class="border p-2">

            <select name="sector" class="border p-2">
                <option value="">Select Sector</option>
                <option value="technology">Technology</option>
                <option value="healthcare">Healthcare</option>
                <option value="education">Education</option>
            </select>

            <input name="province" placeholder="Province" class="border p-2">
            <input name="district" placeholder="District" class="border p-2">

            <input name="address" placeholder="Address" class="border p-2 col-span-2">

            <input type="password" name="password" placeholder="Password" class="border p-2">
            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="border p-2">

        </div>

        <button class="bg-blue-600 text-white px-6 py-2 mt-4 rounded">
            Register
        </button>
    </form>
</div>
@endsection