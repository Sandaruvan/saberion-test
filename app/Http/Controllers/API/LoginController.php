<?php

namespace App\Http\Controllers\API;

use App\Helpers\APIHelper;
use App\Helpers\APIResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $data['token'] =  $user->createToken('MyTestApp')->accessToken;
            $data['user'] =  $user;

            return APIHelper::responseBuilder(Response::HTTP_OK, APIResponseMessage::SUCCESS_STATUS, 'success', $data);
        }
        else{
            return APIHelper::responseBuilder(Response::HTTP_UNAUTHORIZED, APIResponseMessage::UNAUTHORIZED, 'error');
        }
    }
}
