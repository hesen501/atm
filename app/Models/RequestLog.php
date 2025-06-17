<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestLog extends Model
{
    use HasFactory;
    protected $table = 'request_logs';
    const FAILED = 'failed';
    protected $fillable = [
        'request_id',
        'user_id',
        'ip_address',
        'user_agent',
        'response_status',
        'latency_ms',
        'url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
