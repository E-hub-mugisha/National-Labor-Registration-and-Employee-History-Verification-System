@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">

    <h2 class="text-2xl font-bold mb-4">Add Employee</h2>

    <form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-2 gap-4">

            <input name="first_name" placeholder="First Name" class="border p-2">
            <input name="last_name" placeholder="Last Name" class="border p-2">

            <input name="middle_name" placeholder="Middle Name" class="border p-2">

            <input name="national_id" placeholder="National ID" class="border p-2">

            <input name="email" placeholder="Email" class="border p-2">

            <input name="phone" placeholder="Phone" class="border p-2">

            <input type="date" name="date_of_birth" class="border p-2">

            <select name="gender" class="border p-2">
                <option value="">Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <input name="province" placeholder="Province" class="border p-2">
            <input name="district" placeholder="District" class="border p-2">

            <input name="skills" placeholder="Skills" class="border p-2">
            <input name="highest_qualification" placeholder="Qualification" class="border p-2">

            <input name="position" placeholder="Position" class="border p-2">
            <input name="department" placeholder="Department" class="border p-2">

            <input type="date" name="start_date" class="border p-2">

            <input type="file" name="photo" class="border p-2 col-span-2">

        </div>

        <button class="bg-blue-600 text-white px-6 py-2 mt-4 rounded">
            Save Employee
        </button>
    </form>
</div>
@endsection