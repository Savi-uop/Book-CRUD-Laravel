<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>


<div class="container  pt-4">
    <div class="pt-4">
        <h3>Dashboard</h3>
    </div>

    <div class="container mt-5">
        
        <div class="row mt-3">
            <div class="col-md-6">
                <form action="{{ route('books.filter') }}" method="GET" class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search book by name...">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>
        <div class="row mt-3">
        <div class="col-md-6">
            @foreach ($books as $book)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text">Author: {{ $book->author }}</p>
                        <p class="card-text">Price: ${{ $book->price }}</p>
                        <p class="card-text">Stock: {{ $book->stock }}</p>
                        <form action="{{ route('books.borrow') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <button type="submit" class="btn btn-primary">Borrow</button>
                        </form>
                        @if ($book->is_borrowed)
                            <form action="{{ route('books.return') }}" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button type="submit" class="btn btn-warning">Return</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div> 
</div>
    </div>

</div>
