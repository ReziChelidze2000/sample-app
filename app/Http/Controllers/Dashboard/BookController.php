<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\BookRequest;
use App\Http\Resources\Dashboard\BookResource;
use App\Models\Book;
use App\Services\Dashboard\BookService;
use Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function __construct(protected BookService $bookService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = Book::get(['id', 'title', 'description', 'is_published']);

        return $this->success(data: BookResource::collection($data));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookRequest $request): JsonResponse
    {
        $request->user()->books()->create($request->validated());

        return $this->success(message: 'book has been created');
    }

    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(Book $book): JsonResponse
    {
        Gate::authorize('manage', $book);

        $book->load('author:id,name,email');

        return $this->success(data: new BookResource($book));
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(BookRequest $request, Book $book): JsonResponse
    {
        Gate::authorize('manage', $book);

        $book->update($request->validated());

        return $this->success(message: 'book has been updated');
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(Book $book): JsonResponse
    {
        Gate::authorize('manage', $book);

        $book->delete();

        return $this->success(message: 'book has been deleted');
    }

    /**
     * Get top 5 latest published books for auth user
     *
     */
    public function latestPublishedBooks(): JsonResponse
    {
        $data = $this->bookService->latestPublishedBooks(limit: 5);

        return $this->success(data: BookResource::collection($data));
    }
}
