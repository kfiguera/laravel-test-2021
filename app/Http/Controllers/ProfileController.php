<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Http\Resources\PurchasesResource;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * @var User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    private $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function index(){

        return $this->showOne(
            new ProfileResource(auth()->user())
        );
    }
    public function purchases(){

        return $this->showOne(
            PurchasesResource::collection(auth()->user()->transactions)
        );
    }

    public function products(){

        return $this->showOne(
            auth()->user()->products
        );
    }
}
