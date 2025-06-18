<?php
namespace App\Http\Services;
namespace App\Services;

use App\Models\Account;
use App\Models\BankNote;
use App\Models\RequestLog;
use App\Models\Transaction;
use App\Models\TransactionBankNote;
use App\Models\User;
use App\Repositories\CashoutRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use function Pest\Laravel\json;

class CashoutService
{
    protected Logger $logger;
    private CashoutRepository $cashoutRepository;

    public function __construct(CashoutRepository $cashoutRepository)
    {
        $this->logger = Logger::getInstance();
        $this->cashoutRepository = $cashoutRepository;
    }
    public function withdraw($request, $startTime): JsonResponse
    {
        $status = RequestLog::FAILED;
        $amount = $request['amount'];
        $logger = Logger::getInstance();

        $account = $this->cashoutRepository->getAccountWithUser($request['account_id']);
        $user = $account->user;

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

        $userTransactionSumToday = $this->cashoutRepository->getUserTransactionSumToday($user->id);

        if ($userTransactionSumToday > Transaction::DAILY_LIMIT_PER_USER) {
            $logger->log($data, $startTime);
            return response()->json(['status' => 'fail', 'message' => 'Daily limit exceeded']);
        }


        $bankNoteCounts = $this->computeBankNoteCombination($request['currency_id'], $amount);

        $this->cashoutRepository->createTransactionAndDecreaseBalance(
            $user->id,
            $request['currency_id'],
            $amount,
            $bankNoteCounts
        );

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
