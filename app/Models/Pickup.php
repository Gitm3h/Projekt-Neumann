<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'customer_id', 'spediteur_id', 'status', 'date'])]
class Pickup extends Model
{
    public function items() {return $this->hasMany(PickupItem::class);}
    public function user() {return $this->belongsTo(User::class);}
    public function customer() {return $this->belongsTo(Customer::class);}

    public function spediteur() {return $this->belongsTo(User::class, 'spediteur_id');}
}
