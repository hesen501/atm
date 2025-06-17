<?php
namespace App\Http\Services;
namespace App\Services;

use App\Models\RequestLog;
use Illuminate\Support\Str;

class Logger
{
    private static ?Logger $instance = null;

    private function __construct(){}

    private function __clone() {}

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }

    public static function getInstance(): Logger
    {
        if(is_null(self::$instance)){
            self::$instance = new Logger();
        }

        return self::$instance;
    }

    public function log($data, $startTime): void
    {
        $latency = (int)((microtime(true) - $startTime) * 1000);
        RequestLog::query()->create([
            'request_id' => Str::uuid(),
            'user_id' => $data['user_id'],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'response_status' => $data['status'],
            'latency_ms' => $latency,
            'url' => request()->fullUrl(),
        ]);
    }
}
