<?php

namespace App\Http\Controllers;

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
    public function __construct()
    {
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
            if ($sub->total==$sub->repeat)
            {

              \app()->make(StripePaymentController::class)->deduct($sub->id);

            }




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
