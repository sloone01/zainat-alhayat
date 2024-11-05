<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;


    public function creator(){
        return $this->belongsTo(User::class,'created_by','id');
    }

    public function child(){
        return $this->belongsTo(User::class,'child_id','id');
    }

    public function criteria(){
        return $this->belongsTo(Criteria::class,'criteria','id');
    }

}
