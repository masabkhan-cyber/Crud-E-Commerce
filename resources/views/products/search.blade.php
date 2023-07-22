@extends('layouts.welcome')

@section('content')
    <div class="container" style="min-height:1200px;">
        <h1>Search Results</h1>
        <div class="row">
            @if (empty($searchedProducts))
                <div class="col-md-12">
                    <div class="alert alert-info">
                        No products found. Sorry!
                    </div>
                </div>
            @else
                @foreach($searchedProducts as $product)
                    <div class="col-md-4">
                        <div class="card mb-3" style="padding:15px;">
                            <img src="{{ asset('storage/' . $product['image']) }}" class="card-img-top mx-auto" alt="Product Image" style="width: 200px; height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product['name'] }}</h5>
                                <p class="card-text description">{{ $product['description'] }}</p>
                                <p class="card-text price">Price: ${{ $product['price'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
