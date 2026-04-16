<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Already Signed - BotsLMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <div class="bg-white shadow-xl rounded-lg p-8 text-center">
            <div class="text-green-500 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Already Signed</h1>
            <p class="text-gray-600 mb-6">This document was already signed on {{ $document->signed_at->format('d/m/Y H:i') }}.</p>
            <p class="text-sm text-gray-500 italic">If you believe this is an error, please contact support.</p>
        </div>
    </div>
</body>
</html>
