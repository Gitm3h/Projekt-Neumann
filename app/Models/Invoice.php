<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable (['sale_id', 'customer_id', 'invoice_number', 'status', 'date', 'payment_term_days', 'due_date', 'paid_at'])]

class Invoice extends Model
{
    public function sale () {return $this->belongsTo(Sale::class);}
    public function customer () {return $this->belongsTo(Customer::class);}
}
