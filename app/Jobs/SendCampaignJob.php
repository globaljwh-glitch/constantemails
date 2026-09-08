<?php

namespace App\Jobs;

use App\Models\MailCampaign;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendCampaignJob implements ShouldQueue
{
    use Queueable;

    public MailCampaign $campaign;

    public function __construct(MailCampaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function handle(): void
    {
        // We'll write the email sending logic here.
    }
}