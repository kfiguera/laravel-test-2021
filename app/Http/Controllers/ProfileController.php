<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){

        return $this->showOne(
            new ProfileResource(auth()->user())
        );
    }
}
