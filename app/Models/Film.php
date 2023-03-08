<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'release_year',
        'length',
        'description',
        'rating',
        'language_id',
        'special_features',
        'image',
        'created_at'
    ];

    public function language()
    {
        return $this->belongsTo('App\Models\Language');
    }

    public function critics()
    {
        return $this->hasMany('App\Models\Critic');
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class);
    }

    public function scopeTitle($query, Request $request)
    {
        if ($request->has('keyword'))
        {
            $title = $request['keyword'];
            $query->where('title', 'LIKE', '%'.$title.'%');
        }
    }

    public function scopeRating($query, Request $request)
    {
        if ($request->has('rating'))
        {
            $rating = $request['rating'];
            $query->where('rating', $rating);
        }
    }

    public function scopeMin($query, Request $request)
    {
        if ($request->has('minLength'))
        {
            $min = $request['minLength'];
            $query->where('length', '>=', $min);
        }
    }

    public function scopeMax($query, Request $request)
    {
        if ($request->has('maxLength'))
        {
            $max = $request['maxLength'];
            $query->where('length', '<=', $max);
        }
    }
}
