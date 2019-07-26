<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inquiries';
    protected $fillable = ['inq_fname', 'inq_lname', 'message', 'contact', 'email'];
    public $timestamps = false;
}