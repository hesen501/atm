<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashoutRequest;
use App\Services\CashoutService;
use App\Services\UserService;

class CashoutController extends Controller
{
    protected CashoutService $cashoutService;
    protected UserService $userService;

    public function __construct(UserService $userService, CashoutService $cashoutService)
    {
        $this->userService = $userService;
        $this->cashoutService = $cashoutService;
    }

    public function index(CashoutRequest $request){
        $startTime = microtime(true);
        return response()->json($this->cashoutService->withdraw($request->validated(), $startTime));
    }
}
