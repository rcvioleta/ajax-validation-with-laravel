<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\User;

class FormController extends Controller
{
    public function home()
    {
        return view('welcome');
    }

    public function index()
    {
        return view('form');
    }

    public function login(Request $request) 
    {
        $validation = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]); 

        $foundUser = User::find(2);
        $userExist = $foundUser['email']  == $request->username ? true : false;

        if (!$userExist) {
            return response()->json([
                'status' => 200,
                'errors' => [ 
                    'username' => ['Your email was not registered']
                ]
            ], 200);
        }
    }
}
