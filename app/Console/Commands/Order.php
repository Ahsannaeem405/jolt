<?php

namespace App\Console\Commands;

use App\Interfaces\mail_messasge;
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
    public $orderdata;
    public function __construct(step $step,\App\Models\Order $order)
    {
        $this->step=$step;
        $this->order=$order;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders= \App\Models\Order::whereDate('payment_date',Carbon::now()->format('Y-m-d'))
            ->where('status',1)
            ->get();


        foreach ($orders as $order){
            $data= $this->step->getDetailpack($order->package);
            if ($order->repeat!=$order->total || $order->stop!=1)
            {

                try {
                    $stripe = \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                    $charge = \Stripe\Charge::create([
                        'amount' => $data['price'] + intVal($order->addone) * 100, // $15.00 this time
                        'currency' => 'GBP',
                        'customer' => $order->customer_id, // Previously stored, then retrieved
                    ]);
                    if ($order->repeat!=$order->total)
                    {
                        $order->repeat=$order->repeat+1;
                    }

                    $data=array(
                        'view'=>'payment',
                        'subject'=>mail_messasge::payment,
                        'id'=>$order->id,
                        'type'=>'user',
                    );
                    $this->order->SendEmail($data);


                    $next_date=Carbon::createFromFormat('Y-m-d',$order->payment_date)->addMonth(1);
                    $order->payment_date=$next_date;


                    $order->update();
                }
                catch (\Exception $exception)
                {

                    $order->status=0;
                    $order->update();

                    $data=array(
                        'view'=>'error',
                        'subject'=>mail_messasge::error,
                        'id'=>$order->id,
                        'type'=>'user',
                        'error'=>$exception->getMessage(),
                    );
                    $this->order->SendEmail($data);
                }
            }

        }




    }
}
