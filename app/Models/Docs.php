<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Docs extends Model {

/**
 * Set the table name 
 */
	protected $table = 'files';

/*
| The $guarded property should contain an array of attributes that you do not want to be mass assignable.
| All other attributes not in the array will be mass assignable. So, $guarded functions like a "black list".
 */
    	protected $guarded = ['id']; 	// It is like a black list 


}
