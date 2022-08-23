<?php

namespace App\Http\Controllers;

use App\Interfaces\mail_messasge;
use App\Models\Order;
use App\Models\step;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public $step;
    public $order;

    public function __construct(step $step,Order $order)
    {
        $this->step = $step;
        $this->order = $order;
    }


    public function index(){

        $orders=Order::whereDate('payment_date',Carbon::now()->format('Y-m-d'))
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

    public function Sendotp(Request $request){

        $id = $request->session()->get('id');
        $record = step::find($id);
        $otp = rand(10000,100000);
        $record->verification_code = $otp;
        $record->update();

        $data=array(
            'view'=>'otp',
            'subject'=>mail_messasge::otp,
            'type'=>'user',
            'otp' => $otp,
            'email' => $request->email,
        );
        
       $this->order->SendOtp($data);

    }
}
