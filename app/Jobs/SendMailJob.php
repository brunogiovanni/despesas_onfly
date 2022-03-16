<?php

namespace App\Jobs;

use App\Mail\DespesaMail;
use App\Models\Despesa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private string $emailAddress,
        private Despesa $despesa
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/emailData.log'),
        ])->info('despesa', $this->despesa->toArray());
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/email.log'),
        ])->info('email', [$this->emailAddress]);
        $email = new DespesaMail($this->despesa);
        Mail::to($this->emailAddress)->send($email);
    }
}
