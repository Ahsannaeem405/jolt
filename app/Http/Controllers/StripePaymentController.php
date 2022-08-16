<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\step;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StripePaymentController extends Controller
{
    public $step;

    public function __construct(step $step)
    {
        $this->step = $step;
    }

    public function charge(Request $request)
    {
        $id = $request->session()->get('id');
        $record=step::find($id);
        $data = $this->step->getDetail($id);

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
                'email' => $data['record']->data->email_address,
            ]);



            $create=array(
                'f_name'=>$record->data->f_name,
                'l_name'=>$record->data->l_name,
                'email'=>$record->data->email,
                'number'=>$record->data->number,
                'address'=>$record->data->address,
                'pick'=>$record->data->pick,
                'first_name'=>$record->data->first_name,
                'last_name'=>$record->data->last_name,
                'email_address'=>$record->data->email_address,
                'phone_number'=>$record->data->phone_number,
                'street_address'=>$record->data->street_address,
                'apt'=>$record->data->apt,
                'city'=>$record->data->city,
                'country'=>$record->data->country,
                'province'=>$record->data->province,
                'code'=>$record->data->code,
                'package'=>$record->package,
                'addone'=>$data['addone'],
                'repeat'=>0,
                'total'=>$data['months'],
                'payment_date'=>Carbon::createFromFormat('m-d-Y',$record->data->pick)->format('Y-m-d'),
                'status'=>1,
                'complete'=>0,
                'customer_id'=>$customer->id,
            );

      $order=Order::create($create);
            $record->delete();
            Session::flush();

      return redirect('/')->with('success','Order created successfully');


        } catch (\Exception $exception) {

            dd($exception);
            return back()->with('error', $exception->getMessage());
        }

    }
}
