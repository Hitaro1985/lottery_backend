<?php

namespace App\Console\Commands;

use App\slotstate;
use Illuminate\Console\Command;
use App\round;
use App\roundlist;

class NewRound extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'round:new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'End Round and Start New Round';

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
        $round = round::get()->first();
        if (!$round) {
            $name = "Round1";
            $newround = new round();
            $newround->roundname = $name;
            $newround->totalbet = 0;
            $newround->save();
            $newslot = new slotstate();
            $newslot->save();
        } else {
            $oldname = $round->roundname;
            $roundnumber = intval(str_replace("Round", "", $oldname));
            $nextroundnumber = $roundnumber + 1;
            $lastround = roundlist::get()->last();
            $lastcreat = $lastround->created_at;
            $nowcreat = $round->created_at;
            if ($lastcreat->format('Y-m-d') != $nowcreat->format('Y-m-d')) {
                $nextname = "Round1";
            } else {
                $nextname = "Round" . (string)$nextroundnumber;
            }
            $roundlist = new roundlist();
            $roundlist->name = $oldname;
            $roundlist->totalbet = $round->totalbet;
            $roundlist->created_at = $round->created_at;
            $roundlist->save();
            $round->delete();
            $newround = new round();
            $newround->roundname = $nextname;
            $newround->totalbet = 0;
            $newround->save();
            slotstate::truncate();
            $newslot = new slotstate();
            $newslot->save();
        }
        $this->info('New Round Craeted');
    }
}
