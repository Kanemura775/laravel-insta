<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    //
    private $user;
    public function __construct(user $user)
    {
        $this->user = $user;
    }
}
