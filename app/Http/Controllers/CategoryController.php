<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Auth::user()->categories()->orderBy('type')->orderBy('name')->get();

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        Auth::user()->categories()->create($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        $this->ensureOwner($category);
        $categories = Auth::user()->categories()->orderBy('type')->orderBy('name')->get();

        return view('categories.index', compact('categories', 'category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->ensureOwner($category);
        $category->update($this->validatedData($request, $category));

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->ensureOwner($category);

        if ($category->transactions()->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Kategori yang sudah dipakai transaksi tidak dapat dihapus.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Category $category = null): array
    {
        return $request->validate([
            'name' => [
                'required', 'string', 'max:100',
                Rule::unique('categories', 'name')
                    ->where('user_id', Auth::id())
                    ->where('type', $request->input('type'))
                    ->ignore($category?->id),
            ],
            'type' => ['required', Rule::in(['income', 'expense'])],
        ]);
    }

    private function ensureOwner(Category $category): void
    {
        abort_unless($category->user_id === Auth::id(), 404);
    }
}
