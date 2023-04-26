<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public function conversations(){
        return $this->belongsTo(Conversation::class, 'id_conversation');	
        
    }
    function user(){
        return $this->belongsTo(User::class, 'id_User');
    }
    
}
