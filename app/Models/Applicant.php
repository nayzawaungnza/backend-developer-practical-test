<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Applicant extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'job_id',
        'resume',
        'author_id'
    ];

    public function author(){
        return $this->belongsTo(User::class, 'author_id');
    }

    public function job(){
        return $this->belongsTo(Job::class, 'job_id');
    }
    
}