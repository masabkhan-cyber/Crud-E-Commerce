@extends('layouts.products')

@section('content')
    <div class="container">
        <h1>Product List</h1>

        @if (session('success'))
            <div id="success-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-3">
            <a href="{{ route('products.create') }}" class="btn btn-success">Add Product</a>
            <button id="bulk-delete-btn" class="btn btn-danger">Bulk Delete</button>
        </div>

        <table id="product-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all-checkbox"></th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Cost Price</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td><input type="checkbox" class="product-checkbox" data-id="{{ $product['id'] }}"></td>
                        <td>{{ $product['name'] }}</td>
                        <td>{{ $product['description'] }}</td>
                        <td>{{ $product['price'] }}</td>
                        <td>{{ $product['cost_price'] }}</td>
                        <td>{{ $product['category'] }}</td>
                        <td>
                            @if ($product['image'])
                                <img src="{{ asset('storage/' . $product['image']) }}" alt="Product Image" width="50">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="optionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Options
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="optionsDropdown">
                            <li>
                            <a class="dropdown-item" href="{{ route('products.edit', $product['id']) }}">Edit</a>
                            </li>
                            <li>
                            <form action="{{ route('products.destroy', $product['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                            </form>
                            </li>
                            </ul>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <style>
        .gap-2 > * + * {
            margin-left: 8px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.opacity = 0;
                    setTimeout(function() {
                        successMessage.style.display = 'none';
                    }, 1000);
                }, 3000);
            }

            $('#product-table').DataTable({
                "columnDefs": [{
                    "targets": 7,
                    "orderable": false
                }],
                "lengthMenu": [10, 25],
                "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                "language": {
                    "lengthMenu": "Show _MENU_",
                    "info": "Showing _START_ to _END_ of _TOTAL_ products",
                    "search": "Search",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "&raquo;",
                        "previous": "&laquo;"
                    }
                }
            });

            // Select all checkboxes
            $('#select-all-checkbox').change(function() {
                $('.product-checkbox').prop('checked', this.checked);
            });

            // Bulk delete button
            $('#bulk-delete-btn').click(function() {
                var selectedProductIds = $('.product-checkbox:checked').map(function() {
                    return $(this).data('id');
                }).get();

                if (selectedProductIds.length === 0) {
                    alert('Please select at least one product to delete.');
                } else {
                    if (confirm('Are you sure you want to delete the selected products?')) {
                        var form = $('<form>').attr({
                            'method': 'POST',
                            'action': '{{ route('products.bulkDelete') }}'
                        });

                        var csrfField = $('<input>').attr({
                            'type': 'hidden',
                            'name': '_token',
                            'value': '{{ csrf_token() }}'
                        });

                        var idsField = $('<input>').attr({
                            'type': 'hidden',
                            'name': 'ids',
                            'value': selectedProductIds.join(',')
                        });

                        form.append(csrfField, idsField).appendTo('body').submit();
                    }
                }
            });
        });
    </script>
@endsection
