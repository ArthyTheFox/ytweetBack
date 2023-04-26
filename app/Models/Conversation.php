<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    public function messages(){
        return $this->hasMany(Message::class, 'id_message');
    }
    function user(){
        return $this->belongsTo(User::class, 'id_User');
    }
}


