<?php

namespace App\Http\Controllers;

use App\Models\LoanAgreementTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoanAgreementTemplateController extends Controller
{
    public function index()
    {
        $templates = LoanAgreementTemplate::latest()->paginate(15);
        return view('templates.index', compact('templates'));
    }

    public function create()
    {
        $mergeTags = LoanAgreementTemplate::getMergeTags();
        return view('templates.create', compact('mergeTags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        LoanAgreementTemplate::create($validated);

        return redirect()->route('templates.index')
            ->with('success', 'Template created successfully.');
    }

    public function edit(LoanAgreementTemplate $template)
    {
        $mergeTags = LoanAgreementTemplate::getMergeTags();
        return view('templates.edit', compact('template', 'mergeTags'));
    }

    public function update(Request $request, LoanAgreementTemplate $template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $template->update($validated);

        return redirect()->route('templates.index')
            ->with('success', 'Template updated successfully.');
    }
}
