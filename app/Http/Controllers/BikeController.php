<?php

namespace App\Http\Controllers;

use App\Models\step;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BikeController extends Controller
{
    public function index()
    {

        $id = null;

        if (Session::has('id')) {
            $id = Session::get('id');
        }
        if ($id) {
            $record = step::find($id);

            //step 1
            if ($record->step == 1) {
                return view('plan');
            }
            //step 2
            if ($record->step == 2) {

                $back = 1;
                $data = $record->getDetail($record->id);

                return view('checkout', compact('data', 'back'));
            }
            //step 3
            if ($record->step == 3) {
                $back = 2;
                $data = $record->getDetail($record->id);

                return view('detail', compact('data', 'back'));
            }
            //step 4
            if ($record->step == 4) {
                $back = 3;
                $data = $record->getDetail($record->id);

                return view('pick', compact('data', 'back'));
            }

            //step 5
            if ($record->step == 5) {
                $back = 4;
                $data = $record->getDetail($record->id);


                $user = User::where('email', $data['record']->data->email)->exists();

                return view('billing', compact('data', 'user', 'back'));
            }
            //step 6
            if ($record->step == 6) {

                $back = 5;
                $data = $record->getDetail($record->id);
                return view('payment', compact('data', 'back'));

            }


        } else {
            return view('welcome');
        }


    }

    public function language(Request $request)
    {
        $step = new step();
        $step->step = 1;
        $step->save();

        Session::put('id', $step->id);

        return redirect('/');
    }

    public function subscription(Request $request)
    {
        // dd($request->all());

        $id = $request->session()->get('id');

        $record = step::find($id);

        $record->step = 2;
        $record->addone = $request->addone;
        $record->package = $request->package;
        $record->accesories = $request->accesories;
        $record->update();

        return redirect('/');

    }

    public function checkout(Request $request)
    {
        $id = $request->session()->get('id');

        $record = step::find($id);

        $record->step = 3;

        $record->update();

        return redirect('/');

    }

    public function detail(Request $request)
    {

        $id = $request->session()->get('id');

        $record = step::find($id);
        $record->step = 4;
        $record->data = $request->all();

        $record->update();

        return redirect('/');

    }

    public function pick(Request $request)
    {
        $id = $request->session()->get('id');

        $record = step::find($id);
        $record->step = 5;


        $data = collect($record->data);
        $merge = $data->merge($request->all());
        $merge->all();

        $record->data = $merge;
        $record->update();

        return redirect('/');

    }

    public function billing(Request $request)
    {
        $id = $request->session()->get('id');

        $record = step::find($id);
        $record->step = 6;

        $data = collect($record->data);
        $merge = $data->merge($request->all());
        $merge->all();


        $record->data = $merge;
        $record->update();
        $user_id = User::where('email', $record->data->email)->first();
        if ($request->password && !$user_id) {
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $record->data->email,
                'password' => bcrypt($request->password),
            ]);
            $user_id = $user->id;
            Session::put('user_id', $user_id);


        } else {

            $user_id = $user_id->id;
            Session::put('user_id', $user_id);

        }

        return redirect('/');

    }

    public function back(Request $request)
    {
        $id = $request->session()->get('id');

        $record = step::find($id);
        $val = decrypt($request->id);

        // dd($val);
        $record->step = $val;
        $record->update();


        return redirect('/');
    }
}
