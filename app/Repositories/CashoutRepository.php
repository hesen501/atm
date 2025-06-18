<?php
namespace App\Repositories;

use App\Models\Account;
use App\Models\BankNote;
use App\Models\Transaction;
use App\Models\TransactionBankNote;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    public function createTransactionAndDecreaseBalance($account, $currencyId, $amount, $bankNoteCounts)
    {
        DB::transaction(function () use ($account, $currencyId, $amount, $bankNoteCounts) {
            foreach ($bankNoteCounts as $bankNoteId => $count) {
                BankNote::where('id', $bankNoteId)->decrement('count', $count);
            }
            // Create transaction
            $transaction = Transaction::create([
                'user_id' => $account->user_id,
                'currency_id' => $currencyId,
                'amount' => $amount,
                'status' => 'completed',
            ]);

            foreach ($bankNoteCounts as $bankNoteId => $count) {
                TransactionBankNote::create([
                    'transaction_id' => $transaction->id,
                    'bank_note_id' => $bankNoteId,
                    'count' => $count,
                ]);
            }

            $account->amount -= $amount;
            $account->save();
        });
    }
}
