<?php
namespace App\Http\Controllers;

use App\Http\Requests\Account\StoreRequest;
use App\Http\Requests\Account\UpdateRequest;
use App\Services\AccountService;

class AccountController extends Controller
{
    protected AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index()
    {
        return response()->json($this->accountService->getAll());
    }

    public function show($id)
    {
        return response()->json($this->accountService->getById($id));
    }

    public function store(StoreRequest $request)
    {
        return response()->json($this->accountService->create($request->validated()));
    }

    public function update(UpdateRequest $request, $id)
    {
        return response()->json($this->accountService->update($id, $request->validated()));
    }

    public function destroy($id)
    {
        return response()->json($this->accountService->delete($id));
    }
}
