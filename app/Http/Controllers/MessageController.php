<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Message;
use App\Models\UserChat;

use App\Http\Resources\MessageCollection;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param int $userId
     * @param int $chatId
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $userId, int $chatId)
    {
        $lastMessagesCount = $request->input('last');

        $messages = new MessageCollection(Message::where('id_user', '=', $userId)
            ->where('id_chat', '=', $chatId)
            ->when($lastMessagesCount, function ($query, $last){
                return $query->take($last);
            })
            ->get()
        );

        UserChat::where('id_chat', '=', $chatId)
            ->update(['is_new_message' => 0]);

        $data = $messages;
        return response($data, '200');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $userId
     * @param int $chatId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, int $userId, int $chatId)
    {
        $newMessage = new Message();
        $newMessage->text = $request->data;
        $newMessage->date = $request->date;
        $newMessage->id_chat = $chatId;
        $newMessage->id_user = $userId;
        $newMessage->recipient = $request->user_recipient_id;
        $newMessage->is_deleted = 0;
        $newMessage->save();

        UserChat::where('id_chat', '=', $chatId)
            ->update(['is_new_message' => 1]);

        $data = Message::find(Message::max('id'));

        return response($data, '201');
    }

    /**
     * Display the specified resource.
     *
     * @param int $userId
     * @param int $chatId
     * @param int $messageId
     * @return \Illuminate\Http\Response
     */
    public function show(int $userId, int $chatId, int $messageId)
    {
        $message = Message::find($messageId);
        $message->attachmentsInfo->toArray();

        return response($message, '200');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $userId
     * @param int $chatId
     * @param int $messageId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $userId, int $chatId, int $messageId)
    {
        $message = Message::find($messageId);
        $message->text = $request->data;
        $message->date = $request->date;
        $message->save();

        return response($message, '200');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $userId
     * @param int $chatId
     * @param int $messageId
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $userId, int $chatId, int $messageId)
    {
        $message = Message::find($messageId);
        $message->is_deleted = true;
        $message->save();
        $message->delete();

        // добавить софт делит в документы
//        $message->attachmentsInfo->delete();

        return response([
            'success' => 'success',
            'description' => 'Successfully deleted message'
        ], '200');
    }
}
