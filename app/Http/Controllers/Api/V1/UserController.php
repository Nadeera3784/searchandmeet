<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    private $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $users = $this->userRepository->getAll($request->all());
        return $this->sendResponse('success', ['results' => UserResource::collection($users)], 200);
    }

    public function get(Request $request, $user)
    {
        return $this->sendResponse('success', ['results' => new UserResource($user)], 200);
    }

    public function search(Request $request)
    {
        $users = User::with('conversations');

        $users->where('name', 'LIKE', "%$request->q%");

        return response()->json(UserResource::collection($users->get()), 200);
    }
}
