<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Customer;
use App\Models\Document;
use App\Models\LoanAgreementTemplate;
use App\Actions\Loans\CreateLoanAction;
use App\Actions\Loans\GenerateLoanAgreementAction;
use App\Notifications\AgreementReadyForSignatureNotification;
use App\Notifications\LoanApprovedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Loan::class);

        $loans = Loan::with('customer')
            ->latest()
            ->paginate(15);

        return view('loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Loan::class);

        $customers = Customer::all();
        return view('loans.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreateLoanAction $createLoanAction)
    {
        Gate::authorize('create', Loan::class);

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'principal_amount' => 'required|numeric|min:100',
            'interest_rate' => 'required|numeric|min:0',
            'term_months' => 'required|integer|min:1',
        ]);

        $createLoanAction->execute($validated);

        return redirect()->route('loans.index')
            ->with('success', 'Loan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        Gate::authorize('view', $loan);

        $loan->load(['customer', 'repaymentSchedules', 'transactions', 'documents']);
        $templates = LoanAgreementTemplate::where('is_active', true)->get();

        return view('loans.show', compact('loan', 'templates'));
    }

    /**
     * Approve the specified resource.
     */
    public function approve(Loan $loan, \App\Actions\Loans\GenerateRepaymentScheduleAction $generateRepaymentScheduleAction)
    {
        Gate::authorize('approve', $loan);

        $loan->update([
            'loan_status' => 'approved',
            'approval_date' => now(),
        ]);

        $generateRepaymentScheduleAction->execute($loan);

        // Notify customer
        if ($loan->customer->email) {
            $loan->customer->notify(new LoanApprovedNotification($loan));
        }

        return back()->with('success', 'Loan approved and schedule generated.');
    }

    /**
     * Generate a loan agreement.
     */
    public function generateAgreement(Request $request, Loan $loan, GenerateLoanAgreementAction $action)
    {
        Gate::authorize('update', $loan);

        $validated = $request->validate([
            'template_id' => 'required|exists:loan_agreement_templates,id',
        ]);

        $template = LoanAgreementTemplate::findOrFail($validated['template_id']);
        $action->execute($loan, $template);

        return back()->with('success', 'Loan agreement generated successfully.');
    }

    /**
     * Send an agreement for signature.
     */
    public function sendForSignature(Document $document)
    {
        Gate::authorize('update', $document->documentable);

        $loan = $document->documentable;
        
        if ($loan->customer->email) {
            $loan->customer->notify(new AgreementReadyForSignatureNotification($document));
        }

        return back()->with('success', 'Agreement sent to customer for signature.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
