<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Loan Agreement - BotsLMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="bg-indigo-600 px-6 py-4">
                <h1 class="text-white text-xl font-bold">Sign Your Loan Agreement</h1>
            </div>
            
            <div class="p-8">
                <div class="prose max-w-none mb-8 border-b pb-8">
                    {!! $document->content !!}
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-bold mb-4">Your Signature</h3>
                    <p class="text-sm text-gray-600 mb-4 italic">Please draw your signature in the box below using your mouse or touchscreen.</p>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 bg-gray-50">
                        <canvas id="signature-pad" class="w-full h-64 cursor-crosshair"></canvas>
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <button type="button" id="clear" class="text-sm text-red-600 hover:text-red-800 font-medium">
                            Clear Signature
                        </button>
                        
                        <form id="signature-form" action="{{ URL::signedRoute('signature.submit', $document) }}" method="POST">
                            @csrf
                            <input type="hidden" name="signature" id="signature-data">
                            <button type="submit" id="submit-btn" class="bg-indigo-600 text-white px-6 py-2 rounded-md font-bold hover:bg-indigo-700 transition">
                                I Accept & Sign Agreement
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255, 255, 255, 0)',
            penColor: 'rgb(0, 0, 0)'
        });

        // Handle window resizing
        function resizeCanvas() {
            const ratio =  Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }

        window.onresize = resizeCanvas;
        resizeCanvas();

        document.getElementById('clear').addEventListener('click', () => {
            signaturePad.clear();
        });

        document.getElementById('signature-form').addEventListener('submit', (e) => {
            if (signaturePad.isEmpty()) {
                e.preventDefault();
                alert('Please provide a signature before submitting.');
                return;
            }

            document.getElementById('signature-data').value = signaturePad.toDataURL();
            document.getElementById('submit-btn').disabled = true;
            document.getElementById('submit-btn').innerText = 'Processing...';
        });
    </script>
</body>
</html>
