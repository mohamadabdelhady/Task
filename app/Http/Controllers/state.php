<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class state extends Controller
{
    public function getData()
    {
        $allUserCount=User::all()->count();
        $allPost=\App\Models\posts::all()->count();
        $usersWithZeroPosts=User::whereNotIn('id',\App\Models\posts::all('user_id'))->get();
        return compact('allUserCount','allPost','usersWithZeroPosts');
    }
}
