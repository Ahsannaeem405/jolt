<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\step;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(step $step){

        $orders=Order::whereDate('payment_date',Carbon::now()->format('Y-m-d'))
            ->where('status',1)
            ->get();


        foreach ($orders as $order){
           $data= $step->getDetailpack($order->package);
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


                       $next_date=Carbon::createFromFormat('Y-m-d',$order->payment_date)->addMonth(1);
                       $order->payment_date=$next_date;


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
}
