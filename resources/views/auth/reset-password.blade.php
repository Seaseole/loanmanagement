<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - BotsLMS</title>
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
                <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight text-center">Set New Password</h2>
                <p class="text-slate-500 font-medium mt-2 text-center">Secure your account with a new password</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 focus:ring-2 focus:ring-indigo-100 transition-all placeholder:text-slate-300 font-medium">
                    @error('email')
                        <p class="mt-2 text-xs text-rose-500 font-bold ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mt-6">
                    <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">New Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 focus:ring-2 focus:ring-indigo-100 transition-all placeholder:text-slate-300 font-medium"
                        placeholder="••••••••">
                    @error('password')
                        <p class="mt-2 text-xs text-rose-500 font-bold ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mt-6">
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">Confirm New Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-700 focus:ring-2 focus:ring-indigo-100 transition-all placeholder:text-slate-300 font-medium"
                        placeholder="••••••••">
                    @error('password_confirmation')
                        <p class="mt-2 text-xs text-rose-500 font-bold ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-10">
                    <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-bold text-sm shadow-[0_10px_20px_rgba(79,_70,_229,_0.2)] hover:bg-indigo-700 hover:shadow-none transition-all active:scale-[0.98]">
                        Update Password
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
