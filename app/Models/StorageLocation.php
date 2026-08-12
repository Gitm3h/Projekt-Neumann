<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable (['name'])]
class StorageLocation extends Model
{
    public function stocks() {return $this->hasMany(Stock::class);}

}
