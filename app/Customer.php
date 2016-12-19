<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //

    protected $fillable=[

        'created_at',
        'in',
        'out',
        'door',
        'status',
        'company',
        'status2',
        'company2',
        'card_number',
        'card_holder',




    ];

    public $timestamps=false;
    protected $hidden = [
        'password', 'remember_token',
    ];

//    public function getLabelAttribute(){
//        return $this->created_at.''.$this->card_holder.''.$this->card_number;
//
//    }

public function user(){

    return $this->belongsTo('App/User');
}
}
