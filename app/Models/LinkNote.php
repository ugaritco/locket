<?php

declare(strict_types=1);

namespace App\Models;

use Heritage\Database\Eloquent\Builder;
use Heritage\Database\Eloquent\Factories\HasFactory;
use Heritage\Database\Eloquent\Model;
use Heritage\Database\Eloquent\Relations\BelongsTo;
use Heritage\Database\Eloquent\SoftDeletes;

class LinkNote extends Model
{
    /** @use HasFactory<\Database\Factories\LinkNoteFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'link_id',
        'note',
    ];

    /**
     * Get the user that owns this note.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the link this note belongs to.
     */
    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }

    /**
     * Scope to get notes for a specific user.
     */
    public function scopeForUser(Builder $query, int $userId): void
    {
        $query->where('user_id', $userId);
    }

    /**
     * Scope to get notes for a specific link.
     */
    public function scopeForLink(Builder $query, int $linkId): void
    {
        $query->where('link_id', $linkId);
    }

    /**
     * Scope to search notes by content.
     */
    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('note', 'like', '%'.$search.'%');
    }

    /**
     * Scope to get recent notes.
     */
    public function scopeRecent(Builder $query): void
    {
        $query->orderBy('created_at', 'desc');
    }
}
