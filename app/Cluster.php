<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    protected $fillable = [
        'name', 'section', 'user_id','unique_id'
    ];
    public function administrator()
    {
        return $this->belongsTo('App\User');
    }
}
