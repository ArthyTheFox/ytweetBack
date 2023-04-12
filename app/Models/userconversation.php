<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userconversation extends Model
{
    use HasFactory;

    function user(){
        return $this->belongsTo(User::class, 'id_User');
    }
    function conversation(){
        return $this->belongsTo(Conversation::class, 'id_conversation');
    }
}
