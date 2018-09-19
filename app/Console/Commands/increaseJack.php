<?php

namespace App\Console\Commands;

use App\jackpot;
use Illuminate\Console\Command;

class increaseJack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'increase:jack';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increase Jackpot';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        while(1) {
            $jack = jackpot::get()->last();
            if ($jack == null) {
                $newjack = new jackpot();
                $newjack->save();
                $this->info('New Jack Created');
            } else {
                $jack->credit = $jack->credit + 0.1;
                $jack->save();
                $this->info('Jackpot incresed');
            }
            sleep(1);
        }
    }
}
