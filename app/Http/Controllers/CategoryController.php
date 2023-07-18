<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ProductController;

class CategoryController extends Controller
{
    private $jsonFile = 'categories.json';

    public function index()
    {
        $categories = $this->getCategories();
        return view('categories.index', compact('categories'));
    }

    private function getProducts()
    {
        $productsJson = Storage::disk('local')->get('products.json');
        return json_decode($productsJson, true) ?: [];
    }

    private function saveProducts(array $products)
    {
        $productsJson = json_encode($products);
        Storage::disk('local')->put('products.json', $productsJson);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required',
    ]);

    $categoryName = strtolower($validatedData['name']);

    $categories = $this->getCategories();
    $existingCategory = $this->findCategoryByName($categories, $categoryName);

    if ($existingCategory) {
        return redirect()->route('categories.index')->with('error', 'Category already exists.');
    }

    $category = [
        'id' => uniqid(),
        'name' => $validatedData['name'],
    ];

    $categories[] = $category;

    $this->saveCategories($categories);

    return redirect()->route('categories.index')->with('success', 'Category added successfully.');
}

private function findCategoryByName(array $categories, $name)
{
    foreach ($categories as $category) {
        if (strtolower($category['name']) === $name) {
            return $category;
        }
    }

    return null;
}

public function destroy($id)
{
    $categories = $this->getCategories();
    $categoryIndex = $this->findCategoryIndex($categories, $id);

    if ($categoryIndex !== -1) {
        $category = $categories[$categoryIndex];

        // Check if the category is "Uncategorized"
        if (strtolower($category['name']) === 'uncategorized') {
            return redirect()->route('categories.index')->with('error', 'Cannot delete default category.');
        }

        unset($categories[$categoryIndex]);
        $this->saveCategories($categories);

        // Update products with the deleted category
        $products = $this->getProducts();
        foreach ($products as &$product) {
            if (strtolower($product['category']) === strtolower($category['name'])) {
                $product['category'] = 'Uncategorized';
            }
        }
        $this->saveProducts($products);

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    return redirect()->route('categories.index')->with('error', 'Category not found.');
}

public function getCategories()
{
    $categoriesJson = Storage::disk('local')->get($this->jsonFile);
    $categories = json_decode($categoriesJson, true) ?: [];
    // Add default category if it doesn't exist
    $uncategorized = ['id' => 'uncategorized', 'name' => 'Uncategorized'];
    if (!in_array($uncategorized, $categories, true)) {
        $categories[] = $uncategorized;
    }
    return $categories;
}

    private function saveCategories(array $categories)
    {
        $categoriesJson = json_encode($categories);
        Storage::disk('local')->put($this->jsonFile, $categoriesJson);
    }

    private function findCategoryIndex(array $categories, $id)
    {
        foreach ($categories as $index => $category) {
            if ($category['id'] === $id) {
                return $index;
            }
        }

        return -1;
    }
}


