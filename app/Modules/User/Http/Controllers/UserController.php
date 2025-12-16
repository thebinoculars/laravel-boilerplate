<?php

namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Jobs\SendWelcomeEmailJob;
use App\Modules\User\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();

        return response()->json($users);
    }

    public function store(): JsonResponse
    {
        $user = $this->userService->createUser([
            'name' => 'Test User',
            'email' => 'test_' . now()->timestamp . '@example.com',
            'password' => bcrypt('password'),
        ]);

        SendWelcomeEmailJob::dispatch($user);

        return response()->json([
            'message' => 'User created, job dispatched',
            'user' => $user,
        ]);
    }
}
