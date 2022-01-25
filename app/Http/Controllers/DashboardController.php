<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$data = \App\Models\Author::find(1)->with('books')->get();
        //dd($data);

        $books = Book::with('author')->orderBy('created_at', 'desc')->paginate(10);

        return view('dashboard')->with('books', $books);
    }
}
