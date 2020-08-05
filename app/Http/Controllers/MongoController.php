<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Auth\Guard;

class MongoController extends Controller
{
    public function login(Guard $auth_guard) {
        if ($auth_guard->validate()) {
            $user = $auth_guard->user();
            echo 'Success!';
        } else {
            echo 'Not authorized to acces this page!';
        }
    }
}
