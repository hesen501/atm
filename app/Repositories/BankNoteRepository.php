<?php
namespace App\Repositories;

use App\Models\BankNote;

class BankNoteRepository
{
    public function all()
    {
        return BankNote::with('currency')->get();
    }

    public function find($id)
    {
        return BankNote::findOrFail($id);
    }

    public function create(array $data)
    {
        return BankNote::create($data);
    }

    public function update(BankNote $bankNote, array $data)
    {
        $bankNote->update($data);
        return $bankNote;
    }

    public function delete(BankNote $bankNote)
    {
        return $bankNote->delete();
    }
}
