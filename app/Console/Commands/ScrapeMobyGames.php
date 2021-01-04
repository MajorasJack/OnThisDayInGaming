<?php

namespace App\Console\Commands;

use App\Mail\OnThisDayInGaming;
use App\Services\MobyGamesService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ScrapeMobyGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moby-games:scrape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a list of historical gaming related stuff for the current day via email';

    /**
     * @var MobyGamesService
     */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @param MobyGamesService $mobyGamesService
     *
     * @return void
     */
    public function __construct(MobyGamesService $mobyGamesService)
    {
        $this->service = $mobyGamesService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Mail::to(config('mail.to'))->send(new OnThisDayInGaming($this->service->parseData()->toArray()));

        return 0;
    }
}
