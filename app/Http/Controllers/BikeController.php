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

               $data= $record->getDetail($record->id);

                return view('checkout',compact('data'));
            }
            //step 3
            if ($record->step == 3) {

                $data= $record->getDetail($record->id);

               return view('detail',compact('data'));
            }
            //step 4
            if ($record->step == 4) {

                $data= $record->getDetail($record->id);

                return view('pick',compact('data'));
            }


        }
        else{
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
     $id=$request->session()->get('id');

     $record=step::find($id);

     $record->step=2;
     $record->addone=$request->addone;
     $record->package=$request->package;
     $record->update();

     return redirect('/');

    }

    public function checkout(Request $request)
    {
        $id=$request->session()->get('id');

        $record=step::find($id);

        $record->step=3;

        $record->update();

        return redirect('/');

    }

    public function detail(Request $request)
    {
        $id=$request->session()->get('id');

        $record=step::find($id);
        $record->step=4;
        $record->data=json_encode($request->all());

        $record->update();

        return redirect('/');

    }
}
