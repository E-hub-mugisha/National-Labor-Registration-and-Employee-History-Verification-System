<x-layout.auth title="Create Account">

    <div class="min-h-[80vh] flex flex-col items-center justify-center px-4 py-12">

        {{-- Header --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-navy/10 mb-4">
                <svg class="w-7 h-7 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h1 class="font-sora text-2xl font-semibold text-navy">Create an account</h1>
            <p class="text-gray-500 text-sm mt-2 max-w-sm">Select your account type to get started on the National Formal Employment Registry.</p>
        </div>

        {{-- Role cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full max-w-2xl">

            {{-- Employer card --}}
            <a href="{{ route('register.employer') }}"
               class="group bg-white border border-gray-200 hover:border-navy rounded-2xl p-6 transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5 flex flex-col gap-4 text-left">
                <div class="flex items-start justify-between">
                    <div class="w-11 h-11 rounded-xl bg-navy/8 group-hover:bg-navy/12 flex items-center justify-center transition-colors">
                        <svg class="w-6 h-6 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="text-xs text-gold font-medium bg-gold/10 px-2 py-0.5 rounded-full">Company / NGO</span>
                </div>
                <div>
                    <h2 class="font-sora font-semibold text-navy text-lg">Employer</h2>
                    <p class="text-gray-500 text-sm mt-1 leading-relaxed">Register your organisation, manage employee records, verify applicant histories, and request transfers.</p>
                </div>
                <div class="flex flex-col gap-1.5 text-xs text-gray-400">
                    <div class="flex items-center gap-1.5">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-400"></div>Register & verify employees
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-400"></div>Record employment exits & conduct
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-400"></div>Request employee transfers
                    </div>
                </div>
                <div class="flex items-center gap-1 text-navy text-sm font-medium mt-auto pt-2 border-t border-gray-100">
                    Register as employer
                    <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            {{-- Government / Admin card --}}
            <a href="{{ route('register.government') }}"
               class="group bg-white border border-gray-200 hover:border-navy rounded-2xl p-6 transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5 flex flex-col gap-4 text-left">
                <div class="flex items-start justify-between">
                    <div class="w-11 h-11 rounded-xl bg-navy/8 group-hover:bg-navy/12 flex items-center justify-center transition-colors">
                        <svg class="w-6 h-6 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                        </svg>
                    </div>
                    <span class="text-xs text-blue-600 font-medium bg-blue-50 px-2 py-0.5 rounded-full">MIFOTRA / RDB</span>
                </div>
                <div>
                    <h2 class="font-sora font-semibold text-navy text-lg">Government Official</h2>
                    <p class="text-gray-500 text-sm mt-1 leading-relaxed">Access oversight tools, verify registered companies, resolve disputes, and generate labour market reports.</p>
                </div>
                <div class="flex flex-col gap-1.5 text-xs text-gray-400">
                    <div class="flex items-center gap-1.5">
                        <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>Verify & approve companies
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>Resolve employee claims
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>Analytics & labour reports
                    </div>
                </div>
                <div class="flex items-center gap-1 text-navy text-sm font-medium mt-auto pt-2 border-t border-gray-100">
                    Register as official
                    <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

        </div>

        {{-- Note about employees --}}
        <div class="mt-6 max-w-2xl w-full bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 flex gap-3 items-start">
            <svg class="w-4 h-4 text-amber-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <p class="text-xs text-amber-700 leading-relaxed">
                <strong>Employees</strong> do not register here. When an employer registers you, you'll receive your login credentials via email automatically.
            </p>
        </div>

        <p class="mt-6 text-sm text-gray-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-navy font-medium hover:underline">Sign in</a>
        </p>

    </div>

</x-layout.auth>
