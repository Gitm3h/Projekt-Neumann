<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'type', 'size', 'colour', 'weight', 'model_year', 'price', 'min_stock'])]
class Article extends Model
{
    public function stocks() {return $this->hasMany(Stock::class);}
    public function salesItems() {return $this->hasMany(SaleItem::class);}
    public function reservations() {return $this->hasMany(Reservation::class);}

}
