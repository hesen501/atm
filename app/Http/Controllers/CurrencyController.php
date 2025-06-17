<?php
namespace App\Http\Controllers;

use App\Http\Requests\Currency\StoreRequest;
use App\Http\Requests\Currency\UpdateRequest;
use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    protected CurrencyService $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        return response()->json($this->currencyService->getAll());
    }

    public function show($id)
    {
        return response()->json($this->currencyService->getById($id));
    }

    public function store(StoreRequest $request)
    {
        return response()->json($this->currencyService->create($request->validated()));
    }

    public function update(UpdateRequest $request, $id)
    {
        return response()->json($this->currencyService->update($id, $request->validated()));
    }

    public function destroy($id)
    {
        return response()->json($this->currencyService->delete($id));
    }
}
