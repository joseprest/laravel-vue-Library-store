<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // all books
    public function index()
    {
        $books = Book::with('votedUsers')->get()->toArray();
        return array_reverse($books);
    }

    // add book
    public function add(Request $request)
    {
        $book = new Book([
            'title' => $request->title,
            'author' => $request->author
        ]);
        $book->save();

        return response()->json('The book successfully added');
    }

    // edit book
    public function edit($id)
    {
        $book = Book::find($id);
        return response()->json($book);
    }

    // update book
    public function update($id, Request $request)
    {
        $book = Book::find($id);
        $book->update($request->all());

        return response()->json('The book successfully updated');
    }

    // like/dislike book
    public function liker($bookId, Request $request){
        $user = auth()->user();
        if ($request->isLike) {
            $user->votedBooks()->attach($bookId);
        }else {
            $user->votedBooks()->detach($bookId);
        }
        return redirect()->back();
    }

    // delete book
    public function delete($id)
    {
        $book = Book::find($id);
        $book->delete();

        return response()->json('The book successfully deleted');
    }
}
