<?php

declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Facade;
use Kreait\Firebase\Messaging\CloudMessage;

class FirebasePushNotificationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Facade $fcm,
        private string $fcm_token,
        private array $data
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $message = CloudMessage::fromArray([
            'token' => $this->fcm_token,
            'notification' => $this->data,
        ]);

        $this->fcm::messaging()->send($message);
    }
}
