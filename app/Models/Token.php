<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Token extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'img',
        'description',
    ];

    /**
     * The tags that belong to the token.
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeWithFilter($query)
    {
        return $query->when(request()->input('tags'), function ($query) {
            $query->select('tokens.id', 'tokens.img')
                ->join('tag_token', 'tokens.id', '=', 'tag_token.token_id')
                ->join('tags', 'tag_token.tag_id', '=', 'tags.id')
                ->whereIn('tags.id', request()->input('tags'))
                ->groupBy('tokens.id')
                ->havingRaw('COUNT(DISTINCT tags.id) = ?', [count(request()->input('tags'))]);
        });
    }
}
