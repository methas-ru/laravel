<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = ['title', 'due_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔥 ใช้ tag polymorphic
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }
}

