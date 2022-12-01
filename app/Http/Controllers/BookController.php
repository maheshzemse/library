<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book = Book::all();
        return response()->json(['data'=> $book]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = new Book;
            $book->book_name = $request->book_name;
            $book->author = $request->author;
           // $book->cover_image  = $request->cover_image ;

           if($files=$request->file('cover_image')){  
            $name=$files->getClientOriginalName();  
            $files->move('upload',$name);  
            $book->cover_image=$name;  
            }  
            $book->save();
            return response()->json([
                'success' => true,
                'data' => $book
            ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::findOrfail($id);
        return response()->json([
            'success' => true,
            'data' => $book
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);

        return response()->json(['data'=>$book]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book= Book::findOrfail($id);
        $book->book_name = $request->book_name;
        $book->author = $request->author;
        //$book->cover_image  = $request->cover_image ;
        if($files=$request->file('cover_image')){  
            $name=$files->getClientOriginalName();  
            $files->move('upload',$name);  
            $book->cover_image=$name;  
            }  
        if($book->save())
        {
            return response()->json([
                'message' => 'Book Updated successfully',
                'success' => true,
                'data' => $book
            ], 200);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrfail($id);

        if($book->delete())
        {
            return response()->json([
                'message' => 'book Deleted successfully',
                'success' => true,
                'data' => $book
            ], 200);
    }
    }

// -----API fro Issuing a Books Renting a Book-----------------------

public function book_issue(Request $request) 
{
    $book = new BookRecord;
    $book->u_id =Auth::user();
    $book->b_id = $request->b_id;
    $book->issue_date  = $request->issue_date ;
    $book->return_date = $request->return_date;
    $book->book_rent = $request->book_rent;
    $book->return_status = $request->return_status;  
    $book->save();
    return response()->json([
        'success' => true,
        'data' => $book
    ], 200);
}



/// --APi for return a Book-------

 public function return_book(Request $request,$id)
{
    $book= BookRecord::findOrfail($id);

     $book->return_status = $request->return_status;  
     $book->actual_return_date = $request->actual_return_date;  
     if($book->save())
    {
        return response()->json([
            'message' => 'Book Returned successfully',
            'success' => true,
            'data' => $book
        ], 200);

    }
    
}


public function Userwise_rented()
{
    $data =DB::table('book_records')
    ->select('users.firstname','users.lastname','books.book_name','book_records.book_rent')
    ->join('books','books.b_id','=','book_records.b_id')
    ->join ('users','users.u_id', '=', 'book_records.u_id')
    ->join('retrun_status_masters','retrun_status_masters.return_status','=', 'book_records.return_status')
    ->where('book_records.return_status' , '=', 1)
   
    ->get();
    return response()->json([
        'success' => true,
        'data' => $data
    ], 200);

}






}








