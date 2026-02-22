<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaryEntry extends Model
{
    protected $table = 'diary_entries';
    protected $fillable = ['user_id', 'date', 'content'];
    protected $casts = [
        'date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot() {
        parent::boot();

        static::deleting(function($diaryEntry) {
                $diaryEntry->tags()->detach();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function emotions()
    {
        return $this->belongsToMany(Emotion::class, 'diary_entry_emotions', 'diary_entry_id', 'emotion_id')
                    ->withPivot('intensity')
                    ->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'diary_entry_categories', 'diary_entry_id', 'category_id')
                    ->withTimestamps();
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }


}