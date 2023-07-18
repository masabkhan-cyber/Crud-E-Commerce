@extends('layouts.products')

@section('content')
    <div class="container">
        <h1>Edit Product</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product['id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" style="border: 1px solid lightgrey;" value="{{ $product['name'] }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" style="border: 1px solid lightgrey;" required>{{ $product['description'] }}</textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" style="border: 1px solid lightgrey;" value="{{ $product['price'] }}" required>
            </div>

            <div class="mb-3">
                <label for="cost_price" class="form-label">Cost Price</label>
                <input type="number" name="cost_price" id="cost_price" class="form-control" style="border: 1px solid lightgrey;" value="{{ $product['cost_price'] }}" required>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" id="category" class="form-control" style="border: 1px solid lightgrey;" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category['name'] }}" {{ $category['name'] === $product['category'] ? 'selected' : '' }}>
                            {{ $category['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                @if ($product['image'])
                    <img src="{{ asset('storage/' . $product['image']) }}" alt="Product Image" width="100">
                @endif
                <input type="file" name="image" id="image" class="form-control-file" style="border: 1px solid lightgrey;">
            </div>

            <div class="mb-3">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection
