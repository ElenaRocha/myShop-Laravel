<?php

namespace App\Http\Controllers;

use App\Traits\LoadsMockData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\View\View;

class BrandController extends Controller
{
    use LoadsMockData;

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $brands = $this->getBrands();

        return view('brands.index', ['brands' => $brands]);
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Middleware('token:secret123', only: ['create'])]
    public function create(): RedirectResponse
    {
        return redirect()->route('brands.index')
            ->with('success', 'Formulario de creación de marca (simulado)');
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Middleware('token:secret123', only: ['store'])]
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        return redirect()->route('brands.index')
            ->with('success', 'Marca creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $brands = $this->getBrands();

        $brand = $brands[$id] ?? null;

        if (! $brand) {
            abort(404, 'Marca no encontrada');
        }

        return view('brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Middleware('token:secret123', only: ['edit'])]
    public function edit(string $id): RedirectResponse
    {
        return redirect()->route('brands.show', $id)
            ->with('success', 'Marca editada');
    }

    /**
     * Update the specified resource in storage.
     */
    #[Middleware('token:secret123', only: ['update'])]
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        return redirect()->route('brands.show', $id)
            ->with('success', 'Marca actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Middleware('token:secret123', only: ['destroy'])]
    public function destroy(string $id): RedirectResponse
    {
        return redirect()->route('brands.index')
            ->with('success', 'Marca eliminada exitosamente');
    }
}
