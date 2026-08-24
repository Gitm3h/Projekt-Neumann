<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['pickup_id', 'article_id', 'quantity', 'taken_quantity'])]
class PickupItem extends Model
{
    public function pickup() {return $this->belongsTo(Pickup::class);}
    public function article() {return $this->belongsTo(Article::class);}

}
