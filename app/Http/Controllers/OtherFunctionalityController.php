<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OtherFunctionalityController extends Controller
{
    /**
     * Send request to admin to create new chat
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function requestToAdmin(Request $request)
    {
        return response([
            'success' => 'failed',
            'description' => 'Sorry, but this function doesnt exists at the moment'
        ], '404');
    }
}
