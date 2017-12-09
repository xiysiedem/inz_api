<?php
/**
 * Created by PhpStorm.
 * User: krzysztofgrys
 * Date: 11/7/17
 * Time: 6:27 PM
 */

namespace App\Auth;

use App\Exception\ApiException;
use App\Response\ApiResponse;
use App\Users\UsersGateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

            $user = Auth::user();

            $success['token'] = $user->createToken('cryptoPlace')->accessToken;
            $success['user']  = $user;

            return ApiResponse::makeResponse($success);
        }
        throw new ApiException(401, 'Unauthorised');

    }

    public function redirectToProvider($service)
    {
        return Socialite::with($service)->stateless()->redirect()->getTargetUrl();
    }


    public function handleProviderCallback(Request $request, $service)
    {


        $request->get('code');
        $user = Socialite::driver($service)->stateless()->user();

        $user = $this->loginOrCreateAccount($user);


        $success['token'] = $user->createToken('cryptoPlace')->accessToken;
        $success['user']  = $user;

        return ApiResponse::makeResponse($success);
    }


    private function loginOrCreateAccount($user)
    {
        $foundUser = User::where('email', $user->email)->first();

        if (!$foundUser) {
            $user = User::create([
                'name'     => $user->login,
                'email'    => $user->email,
                'password' => bcrypt(''),
            ]);
        } else {
            $user = $foundUser;
        }

        Auth::login($user, true);
        $user = Auth::user();

        return $user;
    }


}