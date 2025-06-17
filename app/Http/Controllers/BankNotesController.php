<?php
namespace App\Http\Controllers;

use App\Http\Requests\BankNote\StoreRequest;
use App\Http\Requests\BankNote\UpdateRequest;
use App\Models\BankNote;
use App\Services\BankNoteService;

class BankNotesController extends Controller
{
    protected BankNoteService $service;

    public function __construct(BankNoteService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll());
    }

    public function show($id)
    {
        return response()->json($this->service->getById($id));
    }

    public function store(StoreRequest $request)
    {
        $bankNote = $this->service->store($request->validated());
        return response()->json($bankNote, 201);
    }

    public function update(UpdateRequest $request, BankNote $bankNote)
    {
        $updated = $this->service->update($bankNote, $request->validated());
        return response()->json($updated);
    }

    public function destroy(BankNote $bankNote)
    {
        $this->service->destroy($bankNote);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
