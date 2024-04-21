<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookCategory;
use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with('category')->get();
        $categories = BookCategory::all();
        return view('books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = BookCategory::all();
        return view('books.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'book_category_id' => 'required'
        ]);
    
        Book::create($request->all());
        
        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = BookCategory::all();
        return view('books.edit', compact('book', 'categories'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'book_category_id' => 'required'
        ]);
    
        $book->update($request->all());
    
        return redirect()->route('books.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index');
    }

    public function filter(Request $request)
    {
        // Get the category ID from the request
        $category_id = $request->input('category_id');

        // Query books based on the selected category if a category is selected
        if ($category_id) {
            $books = Book::where('book_category_id', $category_id)->get();
        } else {
            // If no category is selected, retrieve all books
            $books = Book::all();
        }

        // Retrieve categories for dropdown in the filter form
        $categories = BookCategory::all();

        // Pass the filtered books and categories to the view
        return view('books.index', compact('books', 'categories'));
    }

    // Example logic to record book issuance
    public function borrowBook(Request $request)
    {
        $user = auth()->user(); // Assuming the user is authenticated
        $bookId = $request->input('book_id');

        // Record book issuance in the mapping table
        $user->books()->attach($bookId);

        // Decrease the stock count of the book
        $book = Book::findOrFail($bookId);
        $book->decrement('stock');

        // Redirect or return response
        return redirect()->intended('/dashboard');
        
    }

    // Example logic to record book return
    public function returnBook(Request $request)
    {
        $user = auth()->user(); // Assuming the user is authenticated
        $bookId = $request->input('book_id');

        // Update the book_user record to mark the book as returned
        $user->books()->where('book_id', $bookId)->update(['is_returned' => true]);

        // Increment the stock count of the book
        $book = Book::findOrFail($bookId);
        $book->increment('stock');

        // Redirect or return response
       
    }


}
