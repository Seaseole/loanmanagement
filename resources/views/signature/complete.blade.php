<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signing Complete - BotsLMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white shadow-xl rounded-lg p-8 text-center">
            <div class="text-indigo-600 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Thank You!</h1>
            <p class="text-gray-600 mb-6">Your loan agreement has been successfully signed and submitted. A copy has been sent to your email.</p>
            <p class="text-sm text-gray-500">You may now close this window.</p>
        </div>
    </div>
</body>
</html>
