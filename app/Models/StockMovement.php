<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['article_id', 'user_id','type', 'quantity', 'date'])]

class StockMovement extends Model
{
    public function article () {return $this->belongsTo(Article::class);}
    public function user () {return $this->belongsTo(User::class);}
}
