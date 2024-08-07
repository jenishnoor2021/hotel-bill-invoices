<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ladumor\OneSignal\OneSignal;
use App\Models\Autonotification;

class AutNotifi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aut:notifi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $message = Autonotification::where('id',rand(1,3))->get();

        foreach($message as $mes)  
        {
        //     info($mes->description);
        //    info($mes->getAttributes()['file']);
           $fields = array(
            'included_segments' =>'Subscribed Users',
            'contents' => array("en" =>$mes->description),
            'headings' => array("en"=>"Push Notification"),
            'url' => 'https://handmaker.noorinfotech.in/public/autoimg/'.$mes->getAttributes()['file'],
            'icon' => 'https://handmaker.noorinfotech.in/public/autoimg/'.$mes->getAttributes()['file'],
            'big_picture' => 'https://handmaker.noorinfotech.in/public/autoimg/'.$mes->getAttributes()['file'],
            'content_available' => true,
            );
        // OneSignal::sendPush($fields);
        }
        return 0;
    }
}
