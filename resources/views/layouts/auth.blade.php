<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'NFER-EHVS' }} — National Employment Registry</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

    {{-- Tailwind CDN (swap for compiled in production) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sora: ['Sora', 'sans-serif'],
                        sans: ['DM Sans', 'sans-serif'],
                    },
                    colors: {
                        navy: {
                            DEFAULT: '#19265d',
                            50: '#eef0f9',
                            100: '#d0d5ef',
                            700: '#1a2d6e',
                            900: '#0f1a44'
                        },
                        gold: {
                            DEFAULT: '#C8873A',
                            light: '#f5ede0',
                            dark: '#a06828'
                        },
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background: #f4f5f9;
        }

        .font-sora {
            font-family: 'Sora', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-[#f4f5f9]">

    {{-- Top nav bar --}}
    <nav class="bg-navy text-white px-6 py-3 flex items-center justify-between shadow-md">
        <div class="flex items-center gap-3">
            {{-- Rwanda coat of arms placeholder --}}
            <div class="w-9 h-9 rounded-full bg-gold flex items-center justify-center text-white font-sora font-semibold text-sm">RW</div>
            <div>
                <p class="font-sora font-semibold text-sm leading-tight">NFER-EHVS</p>
                <p class="text-xs text-white/60 leading-tight">National Employment Registry</p>
            </div>
        </div>
        <div class="flex items-center gap-4 text-sm">
            @auth
            <span class="text-white/70">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-white/10 hover:bg-white/20 px-3 py-1.5 rounded text-xs transition">Sign out</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="text-white/70 hover:text-white transition text-sm">Sign in</a>
            <a href="{{ route('register') }}" class="bg-gold hover:bg-gold-dark px-4 py-1.5 rounded text-sm font-medium transition">Register</a>
            @endauth
        </div>
    </nav>

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="max-w-2xl mx-auto mt-4 px-4">
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg px-4 py-3 text-sm flex items-start gap-2">
            <svg class="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="max-w-2xl mx-auto mt-4 px-4">
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- Main content --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="mt-16 py-6 text-center text-xs text-gray-400">
        <p>Republic of Rwanda &mdash; Ministry of Public Service and Labour &mdash; NFER-EHVS v1.0</p>
        <p class="mt-1">All data is protected under Rwanda's Data Protection Law No. 058/2021</p>
    </footer>

</body>

</html>