<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Traits\LoadsMockData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\View;

class SupplierController extends Controller
{
    use LoadsMockData;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $suppliers = $this->getSuppliers();

        return view('suppliers.index', ['suppliers' => $suppliers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Middleware('token:secret123', only: ['create'])]
    public function create(): RedirectResponse
    {
        return redirect()->route('suppliers.index')
            ->with('success', 'Formulario de creación de proveedor (simulado)');
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Middleware('token:secret123', only: ['store'])]
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
        ]);

        return redirect()->route('suppliers.index')
            ->with('success', 'Proveedor creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier): View
    {
        $supplier->load(['address', 'products', 'brands']);

        return view('suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Middleware('token:secret123', only: ['edit'])]
    public function edit(string $id): RedirectResponse
    {
        return redirect()->route('suppliers.show', $id)
            ->with('success', 'Proveedor editado');
    }

    /**
     * Update the specified resource in storage.
     */
    #[Middleware('token:secret123', only: ['update'])]
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
        ]);

        return redirect()->route('suppliers.show', $id)
            ->with('success', 'Proveedor actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Middleware('token:secret123', only: ['destroy'])]
    public function destroy(string $id): RedirectResponse
    {
        return redirect()->route('suppliers.index')
            ->with('success', 'Proveedor eliminado exitosamente');
    }
}
