<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormBuilder extends Model
{
    protected $fillable = ['user_id','name','who_submit','Details','form_code','form_code_expire'];

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }
}
