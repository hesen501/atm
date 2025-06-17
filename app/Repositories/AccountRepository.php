<?php
namespace App\Repositories;

use App\Models\Account;

class AccountRepository
{
    public function all()
    {
        return Account::query()->with(['user','currency'])->get();
    }

    public function find($id)
    {
        return Account::query()->findOrFail($id);
    }

    public function create($data)
    {
        return Account::query()->create($data);
    }

    public function update($id, $data)
    {
        $account = Account::query()->findOrFail($id);
        $account->update($data);
        return $account;
    }

    public function delete($id)
    {
        $account = Account::query()->findOrFail($id);
        return $account->delete();
    }
}
