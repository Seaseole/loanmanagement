<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;

class SignatureController extends Controller
{
    /**
     * Display the agreement for signing.
     */
    public function show(Request $request, Document $document)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'This link has expired or is invalid.');
        }

        if ($document->signed_at) {
            return view('signature.already-signed', compact('document'));
        }

        return view('signature.sign', compact('document'));
    }

    /**
     * Handle the signature submission.
     */
    public function sign(Request $request, Document $document)
    {
        if (!$request->hasValidSignature()) {
            abort(403, 'This link has expired or is invalid.');
        }

        $validated = $request->validate([
            'signature' => 'required|string', // Base64 signature data
        ]);

        $document->update([
            'signed_at' => now(),
            'signature_data' => $validated['signature'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('signature.complete', $document);
    }

    /**
     * Display completion message.
     */
    public function complete(Document $document)
    {
        return view('signature.complete', compact('document'));
    }
}
