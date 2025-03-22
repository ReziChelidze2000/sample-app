<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $is_published
 * @property int $writer_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User|null $author
 * @method static Builder<static>|Book newModelQuery()
 * @method static Builder<static>|Book newQuery()
 * @method static Builder<static>|Book onlyTrashed()
 * @method static Builder<static>|Book query()
 * @method static Builder<static>|Book whereCreatedAt($value)
 * @method static Builder<static>|Book whereDeletedAt($value)
 * @method static Builder<static>|Book whereDescription($value)
 * @method static Builder<static>|Book whereId($value)
 * @method static Builder<static>|Book whereIsPublished($value)
 * @method static Builder<static>|Book whereTitle($value)
 * @method static Builder<static>|Book whereUpdatedAt($value)
 * @method static Builder<static>|Book whereWriterId($value)
 * @method static Builder<static>|Book withTrashed()
 * @method static Builder<static>|Book withoutTrashed()
 * @property int $author_id
 * @method static Builder<static>|Book whereAuthorId($value)
 * @mixin Eloquent
 */
class Book extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['title', 'description', 'author_id','is_published'];

    /**
     * Get the User that owns the Book
     */

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * query to only include published books.
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }
}
