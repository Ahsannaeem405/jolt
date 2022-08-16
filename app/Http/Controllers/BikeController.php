<?php

namespace App\Http\Controllers;

use App\Models\step;
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

                $data = $record->getDetail($record->id);

                return view('checkout', compact('data'));
            }
            //step 3
            if ($record->step == 3) {

                $data = $record->getDetail($record->id);

                return view('detail', compact('data'));
            }
            //step 4
            if ($record->step == 4) {

                $data = $record->getDetail($record->id);

                return view('pick', compact('data'));
            }

            //step 5
            if ($record->step == 5) {

                $data = $record->getDetail($record->id);

                return view('billing', compact('data'));
            }
            //step 6
            if ($record->step == 6) {

                $data = $record->getDetail($record->id);
                return view('payment', compact('data'));

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
        $id = $request->session()->get('id');

        $record = step::find($id);

        $record->step = 2;
        $record->addone = $request->addone;
        $record->package = $request->package;
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
        return redirect('/');

    }
}
