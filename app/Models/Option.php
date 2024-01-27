<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'votes',
        'poll_id',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function vote()
    {
        $this->increment('votes');
    }

    public function unvote()
    {
        $this->decrement('votes');
    }
}
