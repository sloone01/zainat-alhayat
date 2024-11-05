<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public function belong_to(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function inner_comments(){
        return $this->hasMany(Comment::class,'comment_id','id');
    }
}
