<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CustomerController extends Controller
{
    // Menampilkan semua pelanggan
    public function index()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }

    // Menyimpan pelanggan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:customers,email',
            'status' => 'required|in:active,inactive,free',
            'registration_date' => 'required|date',
            'billing_type' => 'required|in:prepaid,postpaid',
        ]);

        $customer = Customer::create($validated);
        return response()->json(['message' => 'Customer created successfully.', 'data' => $customer]);
    }

    // Menampilkan detail pelanggan
    public function show($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }
        return response()->json($customer);
    }

    // Memperbarui pelanggan
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        $validated = $request->validate([
            'name' => 'string|max:255',
            'address' => 'string|max:255',
            'phone' => 'string|max:15',
            'email' => 'email|unique:customers,email,' . $id,
            'status' => 'in:active,inactive,free',
            'registration_date' => 'date',
            'billing_type' => 'in:prepaid,postpaid',
        ]);

        $customer->update($validated);
        return response()->json(['message' => 'Customer updated successfully.', 'data' => $customer]);
    }

    // Menghapus pelanggan
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        $customer->delete();
        return response()->json(['message' => 'Customer deleted successfully.']);
    }
}
