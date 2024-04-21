<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//view user registration form
Route::get('/', function () {
    return view('welcome');
});


// User registration route
Route::post('/register', [UserController::class, 'create'])->name('register');

// User login route
Route::get('/login', [UserController::class, 'loginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');


// User logout route
Route::post('/logout', [UserController::class, 'logout'])->name('logout');


// Display a list of all books with their details
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// Add a new book with a form
Route::get('/books/create', [BookController::class, 'create'])->name('books.create');

// Store a newly created book
Route::post('/books', [BookController::class, 'store'])->name('books.store');

// Display the specified book
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

// Edit the specified book
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');

// Update the specified book
Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');

// Delete the specified book
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

//filter books
Route::get('/books/filter', [BookController::class, 'filter'])->name('books.filter');




// Route for borrowing a book
Route::post('/books/borrow', [BookController::class, 'borrowBook'])->name('books.borrow');

// Route for returning a book
Route::post('/books/return', [BookController::class, 'returnBook'])->name('books.return');

