<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    public function index()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        
    }

    public function destroy(string $id)
    {
        
    }

    public function booksWithCopies(){
        //$user = Auth::user();	//bejelentkezett felhasználó
        //copies: fg neve!!!
        return Book::with('copies')
        //->where('user_id','=', $user->id)
        ->get();
    }

    public function authorsum(){
        $books = DB::table('books')
        ->select('author')  
        ->groupBy('author')
        ->orderBy('author', 'asc')
        ->get();
    return $books;
    }
    
    public function twobook(){
        $authors = DB::table('books')
        ->selectRaw('author, COUNT(*) db')
        ->groupBy('author')
        ->havingRaw('db > 1')
        ->get();
        return $authors;
    }

    public function bstringautrotok(){
        $books = DB::table('books')
            ->where('author', 'like', 'B%') 
            ->get();
        return $books;
    }

    }

