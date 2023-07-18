<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\CategoryController;


class ProductController extends Controller
{
    private $jsonFile = 'products.json';

    public function index()
    {
        $products = $this->getProducts();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categoryController = new CategoryController();
        $categories = $categoryController->getCategories();
        return view('products.create', compact('categories'));
    }
    


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'category' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = [
            'id' => uniqid(),
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'cost_price' => $validatedData['cost_price'],
            'category' => $validatedData['category'] ?: 'Uncategorized',
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $product['image'] = $imagePath;
        } else {
            $product['image'] = 'default-image.png';
        }

        $products = $this->getProducts();
        $products[] = $product;

        $this->saveProducts($products);

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    public function edit($id)
    {
        $categoryController = new CategoryController();
        $categories = $categoryController->getCategories();
        $products = $this->getProducts();
        $product = $this->findProduct($products, $id);

        if ($product) {
            return view('products.edit', compact('product', 'categories'));
        }

        return redirect()->route('products.index')->with('error', 'Product not found.');
    }

    public function update(Request $request, $id)
{
    $products = $this->getProducts();
    $productIndex = $this->findProductIndex($products, $id);

    if ($productIndex !== -1) {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'category' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = $products[$productIndex];
        $product['name'] = $validatedData['name'];
        $product['description'] = $validatedData['description'];
        $product['price'] = $validatedData['price'];
        $product['cost_price'] = $validatedData['cost_price'];
        $product['category'] = $validatedData['category'];

        if ($request->hasFile('image')) {
            // Delete previous image if exists and not the default image
            if ($product['image'] && $product['image'] !== 'default-image.png') {
                Storage::disk('public')->delete($product['image']);
            }

            $imagePath = $request->file('image')->store('images', 'public');
            $product['image'] = $imagePath;
        }

        $products[$productIndex] = $product;
        $this->saveProducts($products);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    return redirect()->route('products.index')->with('error', 'Product not found.');
}

    public function destroy($id)
{
    $products = $this->getProducts();
    $productIndex = $this->findProductIndex($products, $id);

    if ($productIndex !== -1) {
        $product = $products[$productIndex];

        // Check if the image is not the default image
        if (isset($product['image']) && $product['image'] !== 'default-image.png') {
            Storage::disk('public')->delete($product['image']);
        }

        unset($products[$productIndex]);
        $this->saveProducts($products);

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    return redirect()->route('products.index')->with('error', 'Product not found.');
}


    private function getProducts()
    {
        if (Storage::disk('local')->exists($this->jsonFile)) {
            $productsJson = Storage::disk('local')->get($this->jsonFile);
            return json_decode($productsJson, true) ?: [];
        }

        return [];
    }

    private function saveProducts(array $products)
    {
        $productsJson = json_encode($products);
        Storage::disk('local')->put($this->jsonFile, $productsJson);
    }

    private function findProduct(array $products, $id)
    {
        foreach ($products as $product) {
            if ($product['id'] === $id){
                return $product;
            }
        }

        return null;
    }

    private function findProductIndex(array $products, $id)
    {
        foreach ($products as $index => $product) {
            if ($product['id'] === $id) {
                return $index;
            }
        }

        return -1;
    }

    public function bulkDelete(Request $request)
{
    $ids = $request->input('ids');

    if ($ids) {
        $productIds = explode(',', $ids);
        $products = $this->getProducts();

        foreach ($productIds as $productId) {
            $productIndex = $this->findProductIndex($products, $productId);

            if ($productIndex !== -1) {
                $product = $products[$productIndex];

                // Check if the image is not the default image
                if (isset($product['image']) && $product['image'] !== 'default-image.png') {
                    Storage::disk('public')->delete($product['image']);
                }

                // Remove product from array
                unset($products[$productIndex]);
            }
        }

        // Reset array keys
        $products = array_values($products);

        $this->saveProducts($products);

        return redirect()->route('products.index')->with('success', 'Selected products deleted successfully.');
    }

    return redirect()->route('products.index')->with('error', 'No products selected for deletion.');
}

public function search(Request $request)
{
    $query = $request->input('query');
    $products = $this->getProducts();

    $searchedProducts = array_filter($products, function ($product) use ($query) {
        return str_contains(strtolower($product['name']), strtolower($query));
    });

    $errorMessage = null;
    if (empty($searchedProducts)) {
        $errorMessage = 'No products found. Sorry!';
    }

    return view('products.search', compact('searchedProducts', 'errorMessage'));
}



}
