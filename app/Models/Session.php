<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{

    protected $guarded = ['created_by'];
    use HasFactory;

    public function supervisor(){
        return $this->belongsTo(User::class,'supervisor_id','id');
    }
}
