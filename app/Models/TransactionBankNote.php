<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionBankNote extends Model
{
    use HasFactory;
    protected $table = 'transaction_bank_notes';
    protected $fillable = [
        'transaction_id',
        'bank_note_id',
        'count'
    ];

    public function bankNote(): BelongsTo
    {
        return $this->belongsTo(BankNote::class, 'bank_note_id', 'id');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
