<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable (['customer_id', 'article_id', 'quantity', 'status', 'date'])]

class Reservation extends Model
{
    public function customer() {return $this->belongsTo(Customer::class);}
    public function article() {return $this->belongsTo(Article::class);}
}
