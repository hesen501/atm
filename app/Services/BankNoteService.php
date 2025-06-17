<?php
namespace App\Services;

use App\Models\BankNote;
use App\Repositories\BankNoteRepository;

class BankNoteService
{
    protected BankNoteRepository $repo;

    public function __construct(BankNoteRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->all();
    }

    public function getById($id)
    {
        return $this->repo->find($id);
    }

    public function store(array $data)
    {
        return $this->repo->create($data);
    }

    public function update(BankNote $bankNote, array $data)
    {
        return $this->repo->update($bankNote, $data);
    }

    public function destroy(BankNote $bankNote)
    {
        return $this->repo->delete($bankNote);
    }
}
