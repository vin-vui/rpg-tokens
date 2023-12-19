<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
    ];

    /**
     * The tokens that belong to the tag.
     * @return BelongsToMany
     */
    public function tokens(): BelongsToMany
    {
        return $this->belongsToMany(Token::class);
    }
}
