<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    const TYPE_SINGLE = 'single';
    const TYPE_MULTIPLE = 'multiple';

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
}
