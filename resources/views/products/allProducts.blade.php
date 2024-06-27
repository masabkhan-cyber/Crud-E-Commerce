@extends('layouts.welcome')

@section('content')
    <div class="container" style="min-height:1200px;">
    <br>
        <h1>All Products</h1>
        <br>
        <br>
        <div class="row">
            @foreach($paginatedProducts as $product)
                <div class="col-md-3">
                    <div class="card mb-3" style="padding:15px;">
                        <img src="{{ asset('storage/' . $product['image']) }}" class="card-img-top mx-auto" alt="Product Image" style="width: 100%; height: 50%; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product['name'] }}</h5>
                            <p class="card-text description">{{ $product['description'] }}</p>
                            <p class="card-text price">Price: ${{ $product['price'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row justify-content-center">
            <nav aria-label="Pagination">
                <ul class="pagination">
                    @if ($paginatedProducts->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginatedProducts->previousPageUrl() }}" aria-label="Previous">&laquo;</a>
                        </li>
                    @endif

                    @foreach ($paginatedProducts->getUrlRange(1, $paginatedProducts->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $paginatedProducts->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    @if ($paginatedProducts->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginatedProducts->nextPageUrl() }}" aria-label="Next">&raquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">&raquo;</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.description').each(function() {
                var $this = $(this);
                var content = $this.html();
                var truncated = content.substr(0, 100);

                if (content.length > 100) {
                    $this.html(truncated + '... <a href="#" class="see-more">See More</a>');
                }

                $this.on('click', '.see-more', function(e) {
                    e.preventDefault();
                    $this.html(content + ' <a href="#" class="see-less">See Less</a>');
                });

                $this.on('click', '.see-less', function(e) {
                    e.preventDefault();
                    $this.html(truncated + '... <a href="#" class="see-more">See More</a>');
                });
            });
        });
    </script>
@endsection
