<?php

namespace App\Models;

use App\Models\User;
use App\Models\Applicant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
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
    public function applicants(){
        return $this->hasMany(Applicant::class);
    }
    
}