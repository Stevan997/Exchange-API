<?php

namespace App\Console\Commands;

use App\Services\CurrencyService;
use Illuminate\Console\Command;

class UpdateCurrenciesCommand extends Command
{
    protected $signature = 'currency:update';
    protected $description = 'Update currency values';

    /**
     * @var CurrencyService
     */
    private CurrencyService $service;

    /**
     * @param CurrencyService $service
     */
    public function __construct(CurrencyService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle()
    {
        $this->service->sync();
    }
}
