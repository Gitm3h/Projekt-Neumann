<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Fillable(['article_id', 'storage_location_id', 'quantity', 'stored_at'])]
class Stock extends Model
{
    public function article () {return $this->belongsTo(Article::class);}
    public function storageLocation () {return $this->belongsTo(StorageLocation::class);}

}
