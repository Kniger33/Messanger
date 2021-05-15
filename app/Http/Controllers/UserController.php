<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Chat;
use App\Models\Role;
use App\Models\User;
use App\Models\UserChat;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param int $userId
     * @param int $chatId
     * @return \Illuminate\Http\Response
     */
    public function index(int $userId, int $chatId)
    {
        $users = Chat::find($chatId)->users;
        $data = UserResource::collection($users);
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
        $user = new User();
        $user->first_name = $request->name;
        $user->second_name = $request->surname;
        $user->patronymic = $request->patronymic;
        $user->is_deleted = false;
        $user->id_role = Role::where('name', '=', $request->role)->get()[0]['id'];
        $user->save();

        $newUser = User::find(User::max('id'));

        $userChat = new UserChat();
        $userChat->id_user = $newUser->id;
        $userChat->id_chat = $chatId;
        $userChat->is_new_message = false;
        $userChat->save();

        return response([
            $newUser
        ], '200');
    }

    /**
     * Display the specified resource.
     *
     * @param int $userId
     * @param int $chatId
     * @param int $userInChatId
     * @return \Illuminate\Http\Response
     */
    public function show(int $userId, int $chatId, int $userInChatId)
    {
        $user = new UserResource(User::find($userInChatId));
        return response($user, '200');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $userId
     * @param int $chatId
     * @param int $userInChatId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $userId, int $chatId, int $userInChatId)
    {
        $user = User::find($userInChatId);
        $user->first_name = $request->name;
        $user->second_name = $request->surname;
        $user->patronymic = $request->patronymic;
        $user->id_role = Role::where('name', '=', $request->role)->get()[0]['id'];
        $user->save();

        return response($user, '200');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $userId
     * @param int $chatId
     * @param int $userInChatId
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $userId, int $chatId, int $userInChatId)
    {
        $user = User::find($userInChatId);
        $user->is_deleted = true;
        $user->save();
        $user->delete();

        return response([
            'success' => 'success',
            'description' => 'Successfully deleted user'
        ], '200');
    }
}
