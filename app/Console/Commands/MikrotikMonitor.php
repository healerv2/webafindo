<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\MikrotikMonitorService;

class MikrotikMonitor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mikrotik:monitor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor all active Mikrotik devices and collect login logs';

    protected $monitorService;

    public function __construct(MikrotikMonitorService $monitorService)
    {
        parent::__construct();
        $this->monitorService = $monitorService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->info('Starting Mikrotik monitoring...');

        $results = $this->monitorService->monitorAllDevices();

        foreach ($results as $device => $count) {
            $this->info("Device: $device, Logs processed: $count");
        }

        $this->info('Mikrotik monitoring completed successfully');

        return 0;
    }
}
