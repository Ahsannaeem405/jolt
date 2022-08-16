<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class step extends Model
{
    use HasFactory;


    public function getDetail($id)
    {

        $record = step::find($id);
        $data = array();
        if ($record->package == 1) {
            $data['price'] = 129;
            $data['months'] = 1;
            $data['name'] = '1 Month - £129';
        }
        if ($record->package == 2) {
            $data['price'] = 99;
            $data['months'] = 3;
            $data['name'] = '3 Months - £99';
        }
        if ($record->package == 3) {
            $data['price'] = 79;
            $data['months'] = 6;
            $data['name'] = '6 Months - £79';
        }

        $data['addone'] = $record->addone ? 50 : 0;
        $data['total'] = ($data['price']  * $data['months']) + $data['addone'];
        $data['record'] =$record;


        return $data;
    }



    public function setDataAttribute($val){
        $this->attributes['data']=   json_encode($val);
    }


    public function getDataAttribute($val){
       return json_decode($val);
    }




}
