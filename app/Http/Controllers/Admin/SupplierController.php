<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        $metrics = [
            'total' => Supplier::count(),
            'active' => Supplier::where('is_active', true)->count(),
            'total_spend' => Supplier::sum('total_spent'),
            'avg_lead_time' => '0 Days'
        ];
        return view('admin.suppliers.index', compact('suppliers', 'metrics'));
    }

    public function toggleStatus(Supplier $supplier)
    {
        $supplier->update(['is_active' => !$supplier->is_active]);
        return response()->json(['success' => true, 'is_active' => $supplier->is_active]);
    }

    public function show(Supplier $supplier)
    {
        $supplier->load('products', 'purchaseOrders');
        return response()->json($supplier);
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'payment_terms' => 'nullable|string|max:255',
            'lead_time' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'categories' => 'nullable|string',
            'brands' => 'nullable|string',
        ]);

        if (isset($validated['categories'])) {
            $validated['categories'] = array_map('trim', explode(',', $validated['categories']));
        } else {
            $validated['categories'] = [];
        }

        if (isset($validated['brands'])) {
            $validated['brands'] = array_map('trim', explode(',', $validated['brands']));
        } else {
            $validated['brands'] = [];
        }

        Supplier::create($validated);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier registered successfully!');
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:suppliers,name,' . $supplier->id,
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'rating' => 'nullable|numeric|min:0|max:5',
            'payment_terms' => 'nullable|string|max:255',
            'lead_time' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'categories' => 'nullable|string',
            'brands' => 'nullable|string',
        ]);

        if (isset($validated['categories'])) {
            $validated['categories'] = array_map('trim', explode(',', $validated['categories']));
        } else {
            $validated['categories'] = [];
        }

        if (isset($validated['brands'])) {
            $validated['brands'] = array_map('trim', explode(',', $validated['brands']));
        } else {
            $validated['brands'] = [];
        }

        $supplier->update($validated);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated successfully!');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier removed successfully!');
    }
}
