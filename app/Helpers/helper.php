<?php

function accesories($id){

    if ($id==1){
        return [
            'name'=>'Rear Rack',
            'price'=>2,
        ];
    }
}

function accesories_total($arr){
    $total=0;
    if ($arr){
        foreach ($arr as $ar){
            $res=accesories($ar);
            $total=$total+$res['price'];
        }
    }

    return $total;
}
