<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::with(['category', 'offer'])->get();

        return view('products.index', ['products' => $products]);
    }

    /**
     * Display only products that have an active offer
     */
    public function onSale(): View
    {
        $products = Product::with(['category', 'offer'])
            ->whereNotNull('offer_id')
            ->get();

        return view('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        $offers = Offer::all();
        $suppliers = Supplier::all();

        return view('admin.products.create', compact('categories', 'offers', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', '¡Producto creado exitosamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $product->load(['category', 'offer']);
        $category = $product->category;

        return view('products.show', compact('product', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $categories = Category::all();
        $offers = Offer::all();
        $suppliers = Supplier::all();

        return view('admin.products.edit', compact('product', 'categories', 'offers', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    #[Authorize('update', 'product')]
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', '¡Producto actualizado exitosamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Authorize('delete', 'product')]
    public function destroy(Product $product): RedirectResponse
    {
        $imagePath = $product->image;

        $product->delete();

        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    /**
     * Muestra la lista de productos en el panel de administración.
     */
    public function adminIndex(): View
    {
        $products = Product::with(['category', 'offer'])->latest()->get();

        return view('admin.products.index', compact('products'));
    }
}
