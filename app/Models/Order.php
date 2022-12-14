<?php

namespace App\Models;

use App\Mail\subscription;
use App\Mail\SendOtp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Order extends Model
{
    protected $guarded = [];
    use HasFactory;


    public function getDetailpack()
    {
        $id = intval($this->package);

        $data = array();
        if ($id == 1) {
            $data['price'] = 129;
            $data['months'] = 1;
            $data['name'] = '1 Month - £129';
        }
        if ($id == 2) {
            $data['price'] = 99;
            $data['months'] = 3;
            $data['name'] = '3 Months - £99';
        }
        if ($id == 3) {
            $data['price'] = 79;
            $data['months'] = 6;
            $data['name'] = '6 Months - £79';
        }


        return $data;
    }

    public function SendEmail($data)
    {

        $order = Order::find($data['id']);
        $data['rec'] = $order;

        Mail::to($order->email)->queue(new subscription($data));

        $data['type'] = 'admin';
        Mail::to(env('MAIL_ADMIN'))->queue(new subscription($data));

    }

    public function Sendotp($data)
    {
        Mail::to($data['email'])->send(new subscription($data));
    }

    public function setAccesoriesAttribute($val)
    {
        if($val){
            $this->attributes['accesories'] = json_encode($val);
        }
        else{
            $this->attributes['accesories']=null;
        }

    }


    public function getAccesoriesAttribute($val)
    {
        if ($val){
            return json_decode($val);
        }
        else{
            return null;
        }

    }
}
