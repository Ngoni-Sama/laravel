<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Validator;

class UsersController extends BaseController
{
    /**
     * Admin Controller Constructor
     */
    public function __construct()
    {
    }

    /**
     * User List
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        try {
            $result = User::get();

            return $this->sendResponse($result);
        } catch (\Exception $exception) {
            return $this->sendInternalError($exception->getMessage());
        }
    }

    /**
     * Get single user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        try {
            $result = User::find($request->route('id'));

            return $this->sendResponse($result);
        } catch (\Exception $exception) {
            return $this->sendInternalError($exception->getMessage());
        }
    }

    /**
     * Create User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        try {
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);

            if ($user) {
                return $this->sendResponse([
                    'message' => 'Successfully created'
                ]);
            } else {
                return $this->sendResponse([
                    'message' => 'User creation failed'
                ]);
            }
        } catch (\Exception $exception) {
            return $this->sendInternalError($exception->getMessage());
        }
    }

    /**
     * Update User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        try {
            $input = $request->all();
            $user = User::where('id', $request->route('id'))->firstOrFail();
            $result = $user->update([
                "name" => $input["name"],
                "email" => $input["email"],
            ]);

            if ($result) {
                return $this->sendResponse([
                    'message' => 'Successfully Updated'
                ]);
            } else {
                return $this->sendResponse([
                    'message' => 'User update failed'
                ]);
            }
        } catch (\Exception $exception) {
            return $this->sendInternalError($exception->getMessage());
        }
    }

    /**
     * Delete User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        try {
            $user = User::where('id', $request->route('id'))->firstOrFail();
            $result = $user->delete();

            if ($result) {
                return $this->sendResponse([
                    'message' => 'Successfully deleted'
                ]);
            } else {
                return $this->sendResponse([
                    'message' => 'User delete failed'
                ]);
            }
        } catch (\Exception $exception) {
            return $this->sendInternalError($exception->getMessage());
        }
    }
}
