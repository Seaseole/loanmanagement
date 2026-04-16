<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CustomerController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Customer::class);
        $customers = Customer::latest()->paginate(15);
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        Gate::authorize('create', Customer::class);
        $districts = [
            'Central', 'Chobe', 'Ghanzi', 'Kgalagadi', 'Kgatleng', 
            'Kweneng', 'North-East', 'North-West', 'South-East', 'Southern'
        ];
        return view('customers.create', compact('districts'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Customer::class);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'id_number' => 'required|string|unique:customers,id_number',
            'phone_number' => 'required|string|unique:customers,phone_number',
            'email' => 'nullable|email|unique:customers,email',
            'district' => 'required|string',
            'city_town' => 'required|string|max:255',
            'physical_address' => 'required|string',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')
            ->with('success', 'Customer onboarded successfully.');
    }

    public function show(Customer $customer)
    {
        Gate::authorize('view', $customer);
        $customer->load('loans');
        return view('customers.show', compact('customer'));
    }
}
