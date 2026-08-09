<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['sale_id', 'article_id', 'quantity', 'unit_price', 'vat_rate'])]

class SaleItem extends Model
{
    public function sale () {return $this->belongsTo(Sale::class);}
    public function article () {return $this->belongsTo(Article::class);}
}
