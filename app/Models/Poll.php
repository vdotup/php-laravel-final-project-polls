<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

class Poll extends Model
{
    use HasFactory;

    const TYPE_SINGLE = 'single';
    const TYPE_MULTIPLE = 'multiple';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($poll) {
            $poll->token = Str::random(10);
        });
    }

    protected $fillable = [
        'title',
        'text',
        'type',
        'user_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function isSingle()
    {
        return $this->type === self::TYPE_SINGLE;
    }

    public function isMultiple()
    {
        return $this->type === self::TYPE_MULTIPLE;
    }

    public function isActive()
    {
        return $this->start_date <= now() && $this->end_date >= now();
    }

    public function isFinished()
    {
        return $this->end_date < now();
    }

    public function markAsVoted()
    {
        // dd($this->id); -> 16
        Cookie::make('poll_vote_', $this->id, 60 * 24 * 365);
    }

    public function userHasVoted(Request $request)
    {
        $value = Cookie::get('poll_vote_');
        // dd($value); -> null
        return $value === true;
    }
}
