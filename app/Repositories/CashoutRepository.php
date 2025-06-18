<?php
namespace App\Repositories;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;

class CashoutRepository
{
    public function getAccountWithUser($accountId)
    {
        return Account::query()
            ->with('user')
            ->find($accountId);
    }

    public function getUserTransactionSumToday($id)
    {
        return Transaction::query()
            ->where('user_id', $id)
            ->whereBetween('created_at', [time(), time() + 86400])
            ->sum('amount');
    }

    public function create($data)
    {
        return User::query()->create($data);
    }

    public function update($id, $data)
    {
        $user = User::query()->findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = User::query()->findOrFail($id);
        return $user->delete();
    }
}
