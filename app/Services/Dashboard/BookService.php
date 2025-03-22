<?php

namespace App\Services\Dashboard;

use Auth;

class BookService
{
    /**
     * Get latest published books for auth user
     *
     */
    public function latestPublishedBooks(int $limit)
    {
        $user = Auth::user();

        return $user->books()->published()->latest()->limit($limit)->get();
    }
}
