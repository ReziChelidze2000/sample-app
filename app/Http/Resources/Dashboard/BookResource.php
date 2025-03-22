<?php

namespace App\Http\Resources\Dashboard;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /* @var $this Book|BookResource */

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'is_published' => $this->is_published,
            'author' => new AuthorResource($this->whenLoaded('author')),
        ];
    }
}
