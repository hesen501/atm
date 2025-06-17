<?php
namespace App\Http\Services;
namespace App\Services;

use App\Repositories\CurrencyRepository;
use Illuminate\Support\Facades\Hash;

class CurrencyService
{
    protected CurrencyRepository $repo;

    public function __construct(CurrencyRepository $repo)
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

    public function create($data)
    {
        return $this->repo->create($data);
    }

    public function update($id, $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }
}
