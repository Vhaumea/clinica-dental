<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Auth;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   
}
