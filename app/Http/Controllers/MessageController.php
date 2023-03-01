<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;


class MessageController extends Controller
{
    function createMessage(Request $request){
        $message = new Message;

        $message->userSend = $request['userSend'];
        $message->userReceive = $request['userReceive'];
        $message->content = $request['content'];
        

        #la publishDate est égale à la date du jour avec l'heure
        $message->publishDate = date("Y-m-d H:i:s");
        if ($request['pathMediaMessage'] == null) {
            $message->pathMediaMessage = null;
        } else {
            $message->pathMediaMessage = $request['pathMediaMessage'];
        }
        if ($request['reponseMessage'] == null) {
            $message->reponseMessage = null;
        } else {
            $message->reponseMessage = $request['reponseMessage'];
        }
        
        $message->view = false;

        $message->save();

        #retour le message
        return $message;
    }
    function deleteMessage(Request $request) {
        $message = Message::find($request['id']);
        #affiche l'utilisateur trouvé sur la page web
        $message->delete();
        return $message;
    }
   /* function getMessage(Request $request) {
        $message = Message::find($request['id']);
        #affiche l'utilisateur trouvé sur la page web
        return $message;
    }*/
    function getAllMessage(Request $request) {
         #récupère les messages d'une conversation et les trie par date
        $message = Message::where('userSend', $request['userSend'])->where('userReceive', $request['userReceive'])->orderBy('publishDate', 'asc')->get('content', 'publishDate', 'pathMediaMessage', 'reponseMessage', 'view');
        #affiche l'utilisateur trouvé sur la page web
        return $message;
    }
    /**function updateMessage(Request $request) {
        $message = Message::find($request['id']);
        #affiche l'utilisateur trouvé sur la page web
        $message->userSend = $request['userSend'];
        $message->userReceive = $request['userReceive'];
        $message->content = $request['content'];
        $message->publishDate = $request['publishDate'];
        $message->pathMediaMessage = $request['pathMediaMessage'];
        $message->reponseMessage = $request['reponseMessage'];
        $message->idMessage = $request['idMessage'];

        $message->save();

        return $message;
    }*/
}
