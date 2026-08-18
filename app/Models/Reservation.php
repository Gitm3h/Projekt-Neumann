<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['customer_id', 'status', 'date'])]
class Reservation extends Model
{
    public function customer() {return $this->belongsTo(Customer::class);}
    public function items() {return $this->hasMany(ReservationItem::class);}
}
