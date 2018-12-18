<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model {

/**
 * Set the table name
 */
	protected $table = 'folders';

/*
| The $guarded property should contain an array of attributes that you do not want to be mass assignable.
| All other attributes not in the array will be mass assignable. So, $guarded functions like a "black list".
 */
	protected $guarded = ['id']; // It is like a black list

	// ONE to Many Relation
	public function documents() {
		return $this->hasMany(Docs::class, 'folder_id')->where('files.status', '1');
	}

	public function folders() {
		return $this->hasMany(Folder::class, 'parent')->where('folders.status', '1');
	}

}
