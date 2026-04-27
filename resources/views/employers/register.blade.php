@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">

        <h2 class="text-2xl font-bold mb-6 text-gray-800">
            Employer Registration
        </h2>

        <form action="{{ route('employer.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Company Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Company Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="mt-1 w-full border rounded-lg p-2 @error('name') border-red-500 @enderror" required>
                    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- TIN --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">TIN Number</label>
                    <input type="text" name="tin_number" value="{{ old('tin_number') }}"
                        class="mt-1 w-full border rounded-lg p-2 @error('tin_number') border-red-500 @enderror">
                    @error('tin_number') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- Registration Number --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Registration Number</label>
                    <input type="text" name="registration_number" value="{{ old('registration_number') }}"
                        class="mt-1 w-full border rounded-lg p-2">
                </div>

                {{-- Sector --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sector</label>
                    <select name="sector" class="mt-1 w-full border rounded-lg p-2">
                        <option value="">Select Sector</option>
                        <option value="technology">Technology</option>
                        <option value="banking_finance">Banking & Finance</option>
                        <option value="healthcare">Healthcare</option>
                        <option value="education">Education</option>
                        <option value="construction">Construction</option>
                        <option value="agriculture">Agriculture</option>
                        <option value="ngo">NGO / Non-Profit</option>
                        <option value="manufacturing">Manufacturing</option>
                        <option value="retail">Retail</option>
                        <option value="hospitality_tourism">Hospitality & Tourism</option>
                        <option value="bpo_call_center">BPO / Call Center</option>
                        <option value="public_administration">Public Administration</option>
                    </select>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="mt-1 w-full border rounded-lg p-2 @error('email') border-red-500 @enderror" required>
                    @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="mt-1 w-full border rounded-lg p-2">
                </div>

                {{-- Website --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Website</label>
                    <input type="url" name="website" value="{{ old('website') }}"
                        class="mt-1 w-full border rounded-lg p-2">
                </div>

                {{-- Province --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Province</label>
                    <select name="province" id="province"
                        class="mt-1 w-full border rounded-lg p-2">
                        <option value="">Select Province</option>
                        <option value="Kigali City">Kigali City</option>
                        <option value="Northern">Northern</option>
                        <option value="Southern">Southern</option>
                        <option value="Eastern">Eastern</option>
                        <option value="Western">Western</option>
                    </select>
                </div>

                {{-- District --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">District</label>
                    <select name="district" id="district"
                        class="mt-1 w-full border rounded-lg p-2">
                        <option value="">Select District</option>
                    </select>
                </div>

            </div>

            {{-- Address --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <textarea name="address" rows="3"
                    class="mt-1 w-full border rounded-lg p-2">{{ old('address') }}</textarea>
            </div>

            {{-- Description --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700">Company Description</label>
                <textarea name="description" rows="4"
                    class="mt-1 w-full border rounded-lg p-2">{{ old('description') }}</textarea>
            </div>

            {{-- Logo --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700">Company Logo</label>
                <input type="file" name="logo"
                    class="mt-1 w-full border rounded-lg p-2">
            </div>

            {{-- Submit --}}
            <div class="mt-6 flex justify-end">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Register Employer
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    const districts = {
        "Kigali City": ["Gasabo", "Kicukiro", "Nyarugenge"],
        "Northern": ["Musanze", "Gicumbi", "Rulindo", "Burera", "Gakenke"],
        "Southern": ["Huye", "Muhanga", "Nyanza", "Ruhango", "Gisagara", "Nyamagabe", "Nyaruguru", "Kamonyi"],
        "Eastern": ["Rwamagana", "Kayonza", "Ngoma", "Bugesera", "Gatsibo", "Nyagatare", "Kirehe"],
        "Western": ["Rubavu", "Karongi", "Rusizi", "Nyamasheke", "Rutsiro", "Ngororero"]
    };

    document.getElementById('province').addEventListener('change', function () {
        const districtSelect = document.getElementById('district');
        const selectedProvince = this.value;

        districtSelect.innerHTML = '<option value="">Select District</option>';

        if (districts[selectedProvince]) {
            districts[selectedProvince].forEach(function (district) {
                let option = document.createElement('option');
                option.value = district;
                option.text = district;
                districtSelect.appendChild(option);
            });
        }
    });
</script>

@endsection