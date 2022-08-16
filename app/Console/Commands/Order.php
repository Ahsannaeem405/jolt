<?php

namespace App\Console\Commands;

use App\Models\step;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Order extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:user';

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
    public $step;
    public function __construct(step $step)
    {
        $this->step=$step;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $step=$this->step;
        $orders= \App\Models\Order::whereDate('payment_date',Carbon::now()->format('Y-m-d'))
            ->where('status',1)
            ->where('complete',0)
            ->get();


        foreach ($orders as $order){
            $data= $step->getDetailpack($order->package);
            try {
                $stripe = \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $charge = \Stripe\Charge::create([
                    'amount' => $data['price'] + intVal($order->addone) * 100, // $15.00 this time
                    'currency' => 'GBP',
                    'customer' => $order->customer_id, // Previously stored, then retrieved
                ]);
                $order->repeat=$order->repeat+1;
                if($order->repeat==$order->total){
                    $order->complete=1;
                }
                else{
                    $next_date=Carbon::createFromFormat('Y-m-d',$order->payment_date)->addMonth(1);
                    $order->payment_date=$next_date;
                }


                $order->update();
            }
            catch (\Exception $exception)
            {

                $order->status=0;
                $order->update();
            }
        }



    }
}
