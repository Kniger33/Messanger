<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatCollection;
use App\Models\Document;
use App\Models\Message;
use App\Models\User;
use App\Models\UserChat;
use Illuminate\Http\Request;

use App\Models\Chat;
use App\Models\ChatType;

use App\Http\Resources\ChatResource;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param string $userId
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $user = User::find($userId);
        $chats = $user->chats;
        $data = (new ChatCollection($chats))
        ->additional(['meta' => [
            'asd' => 'asd',
    ]]);
        return response($data, '200');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $userId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $userId)
    {
        $chat_type = ChatType::where('name', '=', $request->chat_type)->get();

        $chat = new Chat();
        $chat->name = $request->name;
        $chat->participants_number = $request->participants_number;
        $chat->id_chat_type = $chat_type[0]['id'];
        $chat->is_deleted = false;
        $chat->save();

        $data = Chat::find(Chat::max('id'));

        return response($data, '201');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $userId
     * @param  int  $chatId
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $userid, $chatId)
    {
        $chat = new ChatResource(Chat::find($chatId));

        $lastMessagesCount = $request->input('last');

        $messages = Message::where('id_user', '=', $userid)
            ->where('id_chat', '=', $chatId)
            ->when($lastMessagesCount, function ($query, $last){
                return $query->take($last);
            })
            ->get();

        $chatUsers = UserChat::where('id_chat', '=', $chatId)->get();
        $participants = array();
        foreach ($chatUsers as $user)
        {
            $participant = User::find($user['id_user']);
            array_push($participants, $participant);
        }

        $attachments = array();
        foreach ($messages as $message) {
            $document = Document::find($message['id']);
            if (empty($document)) continue;
            array_push($attachments, $document);
        }
        $chat->additional([
            'messages' => $messages,
            'participants' => $participants,
            'attachments_info' => $attachments,
            ]);

        $data = array_merge($chat->toArray($chat), $chat->additional);
        return response($data, '200');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userId
     * @param  int  $chatId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userid, $chatId)
    {
        $chat = Chat::find($chatId);
        $chat->name = $request->name;
        $id_chat_type = ChatType::where('name', '=', $request->chat_type)->get()[0]['id'];
        $chat->id_chat_type = $id_chat_type;
        $chat->save();

        return response($chat, '200');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $userId
     * @param  int  $chatId
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, int $chatId)
    {
        $chat = Chat::find($chatId);
        $chat->is_deleted = true;
        $chat->save();
        $chat->delete();

//        $messagesToDelete = Message::where('id_chat', '=', $chatId)
//            ->get();

        return response([
            'success' => 'success',
            'description' => 'Successfully deleted chat'
        ], '200');
    }

    /**
     * Проверка на наличие новых сообщений в чате пользователя
     * @param $userId
     * @param $chatId
     * @return \Illuminate\Http\Response
     */
    public function haveNewMessages($userId, $chatId)
    {
        $flag = UserChat::where('id_user', '=', $userId)
            ->where('id_chat', '=', $chatId)
            ->get()[0]['is_new_message'];

        return response($flag, '200');
    }

}
