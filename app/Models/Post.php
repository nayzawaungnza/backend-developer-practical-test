<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'author_id'
    ];

    public function author(){
        return $this->belongsTo(User::class, 'author_id');
    }
    public function likes(){
        return $this->hasMany(Like::class);
    }
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }
}