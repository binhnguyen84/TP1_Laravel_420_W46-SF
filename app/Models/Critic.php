<?php

namespace App\Models;

use App\Models\Film;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Critic extends Model
{
    use HasFactory;

    /**
     * Get the film that owns the Critic
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    /**
     * Get the user that owns the Critic
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
