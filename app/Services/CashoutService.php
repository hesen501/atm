<?php
namespace App\Http\Services;
namespace App\Services;

use App\Models\Account;
use App\Models\BankNote;
use App\Models\RequestLog;
use App\Models\Transaction;
use App\Models\TransactionBankNote;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use function Pest\Laravel\json;

class CashoutService
{
    protected Logger $logger;

    public function __construct()
    {
        $this->logger = Logger::getInstance();
    }
    public function withdraw($request, $startTime): JsonResponse
    {
        $status = RequestLog::FAILED;
        $amount = $request['amount'];
        $logger = Logger::getInstance();

        $account = Account::query()->find($request['account_id']);
        $user = User::query()->find($account->user_id);

        $data = [
            'user_id' => $user->id,
            'status' => $status
        ];

        if (!$account) {
            $logger->log($data, $startTime);
            return response()->json( ['status' => 'fail', 'message' => 'Invalid account']);
        }

        if ($account->amount < $amount) {
            $logger->log($data, $startTime);
            return response()->json(['status' => 'fail', 'message' => 'Insufficient balance']);
        }

        $userTransactionSumToday = Transaction::query()
            ->whereBetween('created_at', [$startTime, $startTime + 86400])
            ->sum('amount');

        if ($userTransactionSumToday > Transaction::DAILY_LIMIT_PER_USER) {
            $logger->log($data, $startTime);
            return response()->json(['status' => 'fail', 'message' => 'Daily limit exceeded']);
        }



        $bankNoteCounts = $this->computeBankNoteCombination($request['currency_id'], $amount);

        DB::transaction(function () use ($account, $request, $amount, $bankNoteCounts) {
            foreach ($bankNoteCounts as $bankNoteId => $count) {
                BankNote::where('id', $bankNoteId)->decrement('count', $count);
            }
            // Create transaction
            $transaction = Transaction::create([
                'user_id' => $account->user_id,
                'currency_id' => $request['currency_id'],
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

        $logger->log($data, $startTime);

        return response()->json(['status' => 'success', 'message' => 'Success']);
    }

    protected function computeBankNoteCombination(int $currencyId,int $amount)
    {
        $bankNotesCounts = [];
        $remaining = $amount;

        $bankNotes = BankNote::query()
            ->where('currency_id', $currencyId)
            ->where('denomination', '<=', $amount)
            ->orderByDesc('denomination')
            ->get();

        foreach ($bankNotes as $bankNote) {
            if ($remaining === 0) {
                break;
            }

            $count = 0;
            if ($remaining < $bankNote->denomination || $bankNote->count == 0) {
                continue;
            } elseif ($bankNote->count > 0) {
                $count = floor($remaining / $bankNote->denomination);
                if ($bankNote->count < $count) {
                    $count = $bankNote->count;
                }
            }

            $remaining -= $count * $bankNote->denomination;
            $bankNotesCounts[$bankNote->id] = $count;
        }

        if ($remaining != 0) {
//            $this->logger->log($status, $startTime);
            return response()->json(['status' => 'fail', 'message' => 'BankNotes not correct']);
        }

        return $bankNotesCounts;
    }
}
