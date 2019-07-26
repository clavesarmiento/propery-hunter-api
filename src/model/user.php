<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class User extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    //Relationships
    public function client() {
    	return $this->belongsTo('App\Models\Client', 'user_id', 'user_id');
    }
}