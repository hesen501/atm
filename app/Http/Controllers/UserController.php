<?php
namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Services\UserService;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return response()->json($this->userService->getAll());
    }

    public function show($id)
    {
        return response()->json($this->userService->getById($id));
    }

    public function store(StoreRequest $request)
    {
        return response()->json($this->userService->create($request->validated()));
    }

    public function update(UpdateRequest $request, $id)
    {
        return response()->json($this->userService->update($id, $request->validated()));
    }

    public function destroy($id)
    {
        return response()->json($this->userService->delete($id));
    }
}
