<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Log;
use Illuminate\Support\Facades\Validator;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log as FacadesLog;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $books = Book::orderBy('created_at', 'desc')->get()->toArray();
        
        $books = $this->paginate($books, 3);
        $books->path('');
        
        //$books = Book::orderBy('created_at', 'desc')->paginate(2);
        return view('pages.books.list', compact('books'));
    }

    public function paginate($items, $perPage = 4, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage ;
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow ,$total ,$perPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'title' => 'required|unique:books|max:255',
                //'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'content' => 'required|max:1000',
                'price' => 'required',
                'year_published' => 'required',
            ]);

            if ($validator->fails()) {

                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();

            }
            
            $coverName = '';
            if($request->file('cover'))
            {
                $image = $request->file('cover');
                $coverName = time().'.'.$image->getClientOriginalExtension();
            }



            $book = new Book();
            $book->title = $request->get('title');
            $book->title = $request->get('title');
            $book->content = $request->get('content');
            $book->price = $request->get('price');
            $book->year_published = $request->get('year_published');
            $book->cover = $coverName;
            $book->author_id = rand(1, 10);

            if($book->save())
            {

                return response()->json($book, 200);

                
                if($request->hasFile('cover'))
                {
                        $destinationPath = public_path('/assets/books/'.$book->id.'/');

                        // If directory is not there create it.

                        if(!is_dir($destinationPath))
                        {
                            mkdir("$destinationPath");
                            chmod("$destinationPath", 0755);
                        }

                        // If directory has images clean first before upload.

                        if(!empty(scandir($destinationPath)))
                        {
                            File::cleanDirectory($destinationPath);
                        }

                        // directory is empty upload image update image name in database.

                        $image->move($destinationPath, $coverName);
                }

                return back()->with('success','Book Added Successfully');
            }
        }catch(Exception $e)
        {
            FacadesLog::error($e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('pages.books.single')->with('book', $book);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('pages.books.edit')->with('book', $book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        try
        {
            // Validate data before updating.
            $validator = Validator::make($request->all(), [
                'title' => 'max:255',
                'cover' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'content' => 'max:1000',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();

            }


            // Update data in database.

            $updated = $book->update([
                "title" => $request->get('title'),
                "content" => $request->get('content'),
                "price" => $request->get('price'),
                "year_published" => $request->get('year_published'),
            ]);

            // Image update.
            if($request->hasFile('cover'))
            {

                if($request->file('cover')) {
                    $image = $request->file('cover');
                    $name = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/assets/books/'.$book->id.'/');

                    // If directory is not there create it.

                    if(!is_dir($destinationPath))
                    {
                        mkdir("$destinationPath");
                        chmod("$destinationPath", 0755);
                    }

                    // If directory has images clean first before upload.

                    if(!empty(scandir($destinationPath)))
                    {
                        File::cleanDirectory($destinationPath);
                    }

                    // directory is empty upload image update image name in database.

                    $image->move($destinationPath, $name);

                    $book->update([
                        'cover' => $name,
                    ]);

                    return back()->with('success','Image Upload successfully');
                }
            }


            if($updated)
            {
                return back()->with('success', 'Book details Updated successfully');
            }

            return back()->with('error', 'Something went wrong');
        }
        catch(Exception $e)
        {
            FacadesLog::error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {

        $data = $book->delete();

        return back()->with('success','Record Deleted Successfully');
    }
}
