<?php

namespace App\Http\Controllers;

use App\Interfaces\mail_messasge;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $order;
    public function __construct(Order $order)
    {
        $this->order=$order;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $subscriptions = Order::where('user_id', $user->id)->get();
        return view('user.subsription', compact('subscriptions'));
    }

    public function status($status, $id)
    {
        $now = Carbon::now()->format('Y-m-d');
        $status = decrypt($status);
        $id = decrypt($id);
        $sub = Order::find($id);
        $sub->stop = $status;
        if ($status == 0) {


            $data=array(
                'view'=>'enable',
                'subject'=>mail_messasge::activated,
                'id'=>$sub->id,
                'type'=>'user',
            );
            $this->order->SendEmail($data);

            if ($sub->total==$sub->repeat)
            {

              \app()->make(StripePaymentController::class)->deduct($sub->id);

            }




        }
        else{
            $data=array(
                'view'=>'disable',
                'subject'=>mail_messasge::deactive,
                'id'=>$sub->id,
                'type'=>'user',
            );
            $this->order->SendEmail($data);
        }

        $sub->update();
        return back()->with('success', 'Status updated successfully');
    }

    public function logout()
    {

        Auth::logout();
        return redirect('/');

    }
}
