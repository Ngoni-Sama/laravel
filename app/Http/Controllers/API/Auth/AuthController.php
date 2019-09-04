<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Carbon\Carbon;
use Validator;

class AuthController extends BaseController
{
    public $appKey;

    /**
     * User Controller Constructor
     */
    public function __construct()
    {

    }

    /**
     * User Login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);


        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        try {
            if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
                $user = Auth::user();

                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                if ($request->remember_me)
                    $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();

                return $this->sendResponse([
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'createdAt' => (string) $user->created_at,
                        'updatedAt' => (string) $user->updated_at,
                    ],
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString(),
                ]);

            } else {
                return $this->sendUnauthorizedError();
            }
        } catch (\Exception $exception) {
            return $this->sendInternalError($exception->getMessage());
        }
    }

    /**
     * User Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);


        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        try {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);

            $tokenResult = $user->createToken('Personal Access Token');

            return $this->sendResponse([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'createdAt' => (string) $user->created_at,
                    'updatedAt' => (string) $user->updated_at,
                ],
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);

        } catch (\Exception $exception) {
            return $this->sendInternalError($exception->getMessage());
        }
    }

    /**
     * User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        try {
            $result = Auth::user();

            return $this->sendResponse($result);
        } catch (\Exception $exception) {
            return $this->sendInternalError($exception->getMessage());
        }
    }

    /**
     * User Logout
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            $accessToken = Auth::user()->token();
            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update([
                    'revoked' => true
                ]);

            $accessToken->revoke();

            return $this->sendResponse("logout success");
        } catch (\Exception $exception) {
            return $this->sendInternalError($exception->getMessage());
        }
    }
}
