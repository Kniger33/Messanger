<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatCollection;
use App\Http\Resources\ChatTypeResource;
use App\Models\Document;
use App\Models\Message;
use App\Models\Role;
use App\Models\User;
use App\Models\UserChatPivot;
use Illuminate\Http\Request;

use App\Models\Chat;
use App\Models\ChatType;

use App\Http\Resources\ChatResource;
use Illuminate\Http\Resources\MergeValue;

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
        $chats = User::find($userId)->chats;
        $data = new ChatCollection($chats);
        $data = $data->additional(['asd' => "asd"]);
        return response($data, '200');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $userId)
    {
        $userRole = Role::find(User::find($userId)->id_role)->name;

        if ($userRole != 'admin')
        {
            return response([
                'success' => 'failed',
                'description' => 'Allowed only for admin'
            ],
            '403');
        }
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
