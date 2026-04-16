<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - BotsLMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-10 py-12 bg-white shadow-[0_20px_50px_rgba(8,_112,_184,_0.05)] overflow-hidden sm:rounded-[2.5rem] border border-gray-50">
            <div class="flex flex-col items-center mb-10">
                <div class="w-16 h-16 bg-sky-50 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Welcome Back</h2>
                <p class="text-slate-500 font-medium mt-2">Sign in to your BotsLMS account</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username or Email -->
                <div>
                    <label for="login" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Username or Email</label>
                    <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus autocomplete="username" 
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 focus:ring-2 focus:ring-indigo-100 transition-all placeholder:text-slate-300 font-medium"
                        placeholder="eugene@botslms.com">
                    @error('login')
                        <p class="mt-2 text-xs text-rose-500 font-bold ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mt-6">
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-widest">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 transition-colors">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 focus:ring-2 focus:ring-indigo-100 transition-all placeholder:text-slate-300 font-medium"
                        placeholder="••••••••">
                    @error('password')
                        <p class="mt-2 text-xs text-rose-500 font-bold ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="block mt-6 ml-1">
                    <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded-lg bg-slate-100 border-none text-indigo-600 shadow-sm focus:ring-indigo-100 transition-all cursor-pointer">
                        <span class="ml-3 text-sm text-slate-500 font-medium group-hover:text-slate-600 transition-colors">Keep me signed in</span>
                    </label>
                </div>

                <div class="mt-10">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-bold text-sm shadow-[0_10px_20px_rgba(79,_70,_229,_0.2)] hover:bg-indigo-700 hover:shadow-none transition-all active:scale-[0.98]">
                        Sign In to Dashboard
                    </button>
                </div>
            </form>
        </div>
        
        <p class="mt-8 text-slate-400 text-xs uppercase tracking-widest font-semibold">
            &copy; {{ date('Y') }} BotsLMS Enterprise
        </p>
    </div>
</body>
</html>
