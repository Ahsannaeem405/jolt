<?php

namespace App\Models;

use App\Mail\subscription;
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
}
