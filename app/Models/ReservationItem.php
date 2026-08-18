<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['reservation_id', 'article_id', 'quantity'])]
class ReservationItem extends Model
{
    public function reservation() {return $this->belongsTo(Reservation::class);}
    public function article() {return $this->belongsTo(Article::class);}
}
