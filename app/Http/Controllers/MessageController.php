<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Psy\Readline\Hoa\Console;
use App\Models\Conversation;
use App\Models\User;
use App\Models\userconversation;
use Illuminate\Support\Str;
use App\Http\Controllers\UserController;


class MessageController extends Controller
{
    function createMessage(Request $request)
    {
        //vérifie si la conversation existe
        $convexist = Conversation::where('id_conversation', $request['id_conversation'])->first();
        if ($convexist == null) {
            return response()->json([
                "message" => "La conversation n'existe pas"
            ], 200);
        } else {

            $message = new Message;
            $message->id_user = $request['id_user'];
            $message->content = $request['content'];
            $message->id_conversation = $request['id_conversation'];

            if ($request['pathMediaMessage'] == null) {
                $message->pathMediaMessage = null;
            } else {
                $message->pathMediaMessage = $request['pathMediaMessage'];
            }

            $message->publishDate = now();

            if ($request['pathMediaMessage'] == null) {
                $message->pathMediaMessage = null;
            } else {
                $message->pathMediaMessage = $request['pathMediaMessage'];
            }
            $message->save();
        }
        return response()->json([
            "message" => "Le message a été créé",
            "id_conversation" => $request['id_conversation'],
            "id_message" => $message->id,
            "id_user" => $message->id_user,

        ], 200);
    }

    function addUserAtConversation(Request $request)
    {
        if (Conversation::where('id_conversation', $request['id_conversation'])->first() == null) {
            return response()->json([
                "message" => "La conversation n'existe pas"
            ], 200);
        } else if (userconversation::where('id_User', $request['user'])->where('id_conversation', $request['id_conversation'])->first() != null) {
            return response()->json([
                "message" => "L'utilisateur est déjà dans la conversation"
            ], 200);
        } else {
            $newUserConv = new userconversation();
            $newUserConv->id_User = $request['newUser'];
            $newUserConv->id_conversation = $request['id_conversation'];
            $newUserConv->save();
            return response()->json([
                "message" => "L'utilisateur a été ajouté à la conversation"
            ], 200);
        }
    }


    function createConversation(Request $request)
    { //pour cette route il faut en paramètre userSend, userReciev, titre
        $convSend =  userconversation::where('id_User', $request['userSend'])->pluck('id_conversation')->toArray();
        $convReciev = userconversation::where('id_User', $request['userReceive'])->pluck('id_conversation')->toArray();
        // $titre= Conversation::where('titre', $request['titre'])->first();
        //vérifie s'ils ont un élément en commun
        $convexist = array_intersect($convSend, $convReciev);

        // si convexist a une taille supérieur à 0 alors on fait
        if (sizeof($convexist) == 0 /*or $titre !=$request['titre'] or $titre == null*/) {
            $newConv = new Conversation();
            if ($request['titre'] == null) {
                $user1 = User::where('id', $request['userSend'])->get("username")->first();
                $user2 = User::where('id', $request['userReceive'])->get("username")->first();
                $newConv->titre = "Conversation de " . $user1->username . " et " . $user2->username;
            } else {
                $newConv->titre = $request['titre'];
            }
            //id de la conversation est égale à l'id de la dernière conversation +1
            /* $max = Conversation::orderBy('id_conversation', 'ASC')->first();
            if ($max == null) {
                $newConv->id_conversation = 1;
            } else {
                $newConv->id_conversation = $max + 1;
            }
            print_r($max + 1);*/
            $id_conv = random_int(1, 1000000000);
            if (Conversation::where('id_conversation', $id_conv)->first() != null) {
                $id_conv = random_int(1, 1000000000);
            }

            $newConv->id_conversation = $id_conv;
            $newConv->save();

            $newUserConv = new userconversation();
            $newUserConv->id_User = $request['userSend'];
            $newUserConv->id_conversation = $id_conv;
            $newUserConv->save();
            $newUserConv = new userconversation();
            $newUserConv->id_User = $request['userReceive'];
            $newUserConv->id_conversation = $id_conv;
            $newUserConv->save();
            return response()->json([
                "message" => "La conversation a été créée",
                "id_conversation" => $id_conv,
                "convExist" => false
            ], 200);
        } else {
            //$id_conv = $convexist mais que le premier élément
            $id_conv = array_values($convexist);
            return response()->json([
                "message" => "La conversation existe déjà",
                "id_conversation" => $id_conv[0],
                "convExist" => true
            ], 200);
        }
    }


    function deleteMessage(Request $request, $idconversation, $idmessage)
    {
        if ($idconversation === null) {
            return response()->json([
                "message" => "La conversation n'existe pas"
            ], 200);
        }
        $message = Message::find($idmessage);
        #affiche l'utilisateur trouvé sur la page web
        $message->delete();
        return response()->json([
            "message" => "Le message a été supprimé"
        ], 200);
    }

    /*function viewMessage(Request $request)
    {
        $message = Message::find($request['id']);
        #affiche l'utilisateur trouvé sur la page web
        $message->view = true;
        $message->save();
        return $message;
    }*/
    /* function getMessage(Request $request) {
        $message = Message::find($request['id']);
        #affiche l'utilisateur trouvé sur la page web
        return $message;
    }*/
    function getAllMessageConversation(Request $request) # pour cette metode il faut dans la requête id
    {
        //récupère tous les messages de la conversation
        $conversation = Conversation::where('id_conversation', $request['id'])->get();
        if ($conversation == null) {
            return response()->json([
                "message" => "La conversation n'existe pas"
            ], 200);
        } else {
            $messages = Message::where('id_conversation', $request['id'])->orderBy('created_at');
            $table= $messages->get()->pluck('user')->toArray();
            
            return response()->json([
                "message"=> $messages->get(),
                "user"=> collect($table)->unique('id')->values()->all()
                ,
            ], 200);
        }
    }

    function getAllconversation(Request $request)
    {
        //récupère toutes les conversation d'un utilisateur
        
            $userconv = userconversation::where('id_User', $request['id'])->get();
            $conv = Conversation::whereIn('id_conversation', $userconv->pluck('id_conversation'))->get();
            
            return $conv;
        
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
