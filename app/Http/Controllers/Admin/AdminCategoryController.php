<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $categories = Category::withCount('listings')->orderBy('name')->paginate(15);
        
        return view('admin.categories.index', compact('categories'));
    }
    
    public function create()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        return view('admin.categories.create');
    }
    
    public function store(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50'
        ]);
        
        Category::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'icon' => $validated['icon'],
            'active' => true
        ]);
        
        return redirect()->route('admin.categories.index')->with('success', 'Kategoria u krijua me sukses.');
    }
    
    public function edit($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }
    
    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
            'active' => 'boolean'
        ]);
        
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'icon' => $validated['icon'],
            'active' => $request->has('active')
        ]);
        
        return redirect()->route('admin.categories.index')->with('success', 'Kategoria u përditësua me sukses.');
    }
    
    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $category = Category::findOrFail($id);
        
        if ($category->listings()->count() > 0) {
            return back()->withErrors(['error' => 'Nuk mund të fshini një kategori që përmban listime.']);
        }
        
        $category->delete();
        
        return redirect()->route('admin.categories.index')->with('success', 'Kategoria u fshi me sukses.');
    }
}