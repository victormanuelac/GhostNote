<?php

namespace App\Console\Commands;

use App\Models\Secret;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupSecrets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'secrets:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hard delete expired or burned secrets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = Secret::where('expiration_time', '<', Carbon::now())
            ->orWhere('is_burned', true)
            ->delete();

        $this->info("Deleted {$count} expired or burned secrets.");
    }
}
