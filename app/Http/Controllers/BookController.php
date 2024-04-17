<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookController extends Controller
{
    public function index(): ResourceCollection
    {
        return BookResource::collection(Book::all());
    }

    public function store(StoreBookRequest $request)
    {
        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'year' => $request->year,
        ]);

        return response(['message' => 'Book created with success!'], 201);
    }

    public function show(Book $book): BookResource
    {
        return new BookResource($book);
    }

    public function update(UpdateBookRequest $request, Book $book): Response|ResponseFactory
    {
        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'year' => $request->year,
        ]);

        return response(['message' => 'Book updated with success!'], 201);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response(['message' => 'Book deleted with success!'], 201);
    }
}
