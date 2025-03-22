<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    /**
     * Determine whether the user can view, update or delete the model.
     */
    public function manage(User $user, Book $book): bool
    {
        return $book->author_id == $user->id;
    }
}
