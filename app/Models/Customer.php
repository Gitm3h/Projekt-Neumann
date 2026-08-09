<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

# [Fillable (['user_id', 'name', 'type', 'street', 'house_number', 'postal_code', 'city', 'vat_id'])
class Customer extends Model
{
    public function users () {return $this->belongsTo(User::class);}
    public function invoices () {return $this->hasMany(Invoice::class);}
    public function reservations () {return $this->hasMany(Reservation::class);}
}
