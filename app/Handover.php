<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Handover extends Model
{
    /**
     * This model is special, as it's using the table non-prefixed mysql connection and garthers data provided by Handover
     */
    protected $connection = 'mysql-handover';
    public $table = 'users';
    public $timestamps = false;

    protected $fillable = ['atc_active', 'visiting_controller'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

}
