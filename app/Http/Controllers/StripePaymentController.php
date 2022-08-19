<?php

namespace App\Http\Controllers;

use App\Interfaces\mail_messasge;
use App\Models\Order;
use App\Models\step;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StripePaymentController extends Controller
{
    public $step;
    public $order;

    public function __construct(step $step,Order $order)
    {
        $this->step = $step;
        $this->order = $order;
    }

    public function charge(Request $request)
    {
        $id = $request->session()->get('id');
        $record = step::find($id);
        $data = $this->step->getDetail($id);


        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $token = $stripe->tokens->create([

                'card' => [
                    'number' => $request->card_number,
                    'exp_month' => $request->card_expiry_month,
                    'exp_year' => $request->card_expiry_year,
                    'cvc' => $request->card_cvc,
                ]
            ]);


            $stripe = \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $customer = \Stripe\Customer::create([
                'source' => $token->id,
                'email' => $data['record']->data->email,
            ]);


            $create = array(
                'f_name' => $record->data->f_name,
                'l_name' => $record->data->l_name,
                'email' => $record->data->email,
                'number' => $record->data->number,
                'address' => $record->data->address,
                'pick' => $record->data->pick,
                'first_name' => $record->data->first_name,
                'last_name' => $record->data->last_name,
                'phone_number' => $record->data->phone_number,
                'street_address' => $record->data->street_address,
                'apt' => $record->data->apt,
                'city' => $record->data->city,
                'country' => $record->data->country,
                'province' => $record->data->province,
                'code' => $record->data->code,
                'package' => $record->package,
                'addone' => $data['addone'],
                'repeat' => 0,
                'total' => $data['months'],
                'payment_date' => Carbon::createFromFormat('m-d-Y', $record->data->pick)->format('Y-m-d'),
                'status' => 1,
                'stop' => 0,
                'accesories' => $record->accesories,
                'customer_id' => $customer->id,
                'user_id' => Session::get('user_id'),
            );

            $order = Order::create($create);
            $record->delete();
            Session::flush();

            $data=array(
                'view'=>'order',
                'subject'=>mail_messasge::order,
                'id'=>$order->id,
                'type'=>'user',
            );
            $this->order->SendEmail($data);


            return redirect('/')->with('success', 'Order created successfully');


        }
        catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

    }

    public function chargeNow(Request $request, $id)
    {
        $sub = Order::find($id);


//dd($record->data);


        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $token = $stripe->tokens->create([

                'card' => [
                    'number' => $request->card_number,
                    'exp_month' => $request->card_expiry_month,
                    'exp_year' => $request->card_expiry_year,
                    'cvc' => $request->card_cvc,
                ]
            ]);


            $stripe = \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $customer = \Stripe\Customer::create([
                'source' => $token->id,
                'email' => $sub->email,
            ]);

            $sub->customer_id = $customer->id;
            $sub->stop = 0;
            $sub->update();


           $res= $this->deduct($sub->id);


           if ($res){
               return redirect('subscription')->with('success', 'Payment successfully');

           }
           else{
               return redirect('subscription')->with('error', 'Payment error');

           }


        } catch (\Exception $exception) {


            return back()->with('error', $exception->getMessage());
        }

    }

    public function payNow($id)
    {
        $id = decrypt($id);
        $subscription = Order::find($id);

        return view('user.paynow', compact('subscription'));
    }

    public function deduct($id)
    {
        $step=new step();
        $now = Carbon::now()->format('Y-m-d');
        $order = Order::find($id);
        $data= $step->getDetailpack($order->package);
        if ($order->repeat!=$order->total || $order->stop!=1)
        {

            try {
                $stripe = \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $charge = \Stripe\Charge::create([
                    'amount' => $data['price'] + intVal($order->addone) + accesories_total($order->accesories) * 100, // $15.00 this time
                    'currency' => 'GBP',
                    'customer' => $order->customer_id, // Previously stored, then retrieved
                ]);
                if ($order->repeat!=$order->total)
                {
                    $order->repeat=$order->repeat+1;
                }


                $next_date=Carbon::createFromFormat('Y-m-d',$now)->addMonth(1);
                $order->payment_date=$next_date;

                $order->status=1;
                $order->update();


                $data=array(
                    'view'=>'payment',
                    'subject'=>mail_messasge::payment,
                    'id'=>$order->id,
                    'type'=>'user',
                );
                $this->order->SendEmail($data);

                return  true;
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

                return false;
            }
        }
    }
}
