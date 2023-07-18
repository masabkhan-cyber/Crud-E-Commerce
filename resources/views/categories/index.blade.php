@extends('layouts.category')

@section('content')
    <div class="container">
        <h1>Categories</h1>

        @if (session('success'))
            <div class="alert alert-success" id="success-message">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('success-message').style.display = 'none';
                }, 2000);
            </script>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" id="error-message">
                {{ session('error') }}
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('error-message').style.display = 'none';
                }, 2000);
            </script>
        @endif

        <div class="mb-3">
            <a href="{{ route('categories.create') }}" class="btn btn-success">Add Category</a>
        </div>

        <div class="table-responsive">
            <table id="category-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category['name'] }}</td>
                            <td>
                                <form action="{{ route('categories.destroy', $category['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#category-table').DataTable({
            responsive: true,
            columnDefs: [
                { targets: [1], orderable: false },
            ],
            language: {
                lengthMenu: 'Show _MENU_',
                info: 'Showing _START_ to _END_ of _TOTAL_ categories',
                search: 'Search',
                paginate: {
                    first: 'First',
                    last: 'Last',
                    next: '&raquo;',
                    previous: '&laquo;'
                }
            },
            lengthMenu: [10, 25], // Define available options for items per page
            pageLength: 10, // Set the default number of items per page
        });
    });
    </script>
@endsection
