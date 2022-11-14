<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\verification_code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class Authentication extends Controller
{
    /**
     * @throws \Exception
     */
    public function register(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => 'required',
            'phoneNum' => 'required|unique:users|min:11',
            'password' => 'required|min:6',
        ]);


        if ($validator->fails()) {
            return ($validator->errors());
        }

        $user=User::create([
            'name' => $request['name'],
            'phoneNum' => $request['phoneNum'],
            'password' => Hash::make($request['password']),
        ]);


        $randomNumber = random_int(100000, 999999);
        verification_code::create([
            'user_id'=>$user['id'],
            'verification_code'=>$randomNumber
        ]);
        Log::info($randomNumber);
        $token=$user->createToken('access token')->plainTextToken;
        return compact('user','token');

    }

    public function logIn(Request $request)
    {
        $credentials = $request->validate([
            'phoneNum' => ['required'],
            'password' => ['required'],
        ]);
//        dd($credentials);
        if (Auth::attempt($credentials)) {
            $user=\auth()->user();
            $token=$user->createToken('access token')->plainTextToken;
            return compact('user','token');
        }
        else
        return response('wrong credentials!');

    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'phone' => ['required'],
            'code' => ['required'],
        ]);
        $userPhone=$request['phone'];
        $code=$request['code'];
        $verificationCode=verification_code::whereIn('user_id',User::where('phoneNum',$userPhone)->select('id')->first())->select('verification_code')->first();
        $is_verfied=User::where('phoneNum',$userPhone)->select('isVerified')->first();
        if ($is_verfied['isVerified'])
            return response('you are already verified.',403);
        elseif($verificationCode['verification_code']==$code)
        {
            $user=User::where('phoneNum',$userPhone)->first();
            $user->isVerified=true;
            $user->save();
            return response('verification succeeded, you can now log in into your account',200);
        }
        else
        return response('verification failed',403);
    }
}
