<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
// use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Model;

// use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract {
	use Authenticatable;

/**
 * Set the table name
 */
	protected $table = 'users';

/*
| The $guarded property should contain an array of attributes that you do not want to be mass assignable.
| All other attributes not in the array will be mass assignable. So, $guarded functions like a "black list".
 */
	protected $guarded = ['id']; // It is like a black list

/**
 *    Fillable serves as a "white list" of attributes that should be mass assignable
 */
	protected $fillable = [
		'name',
		'email',
		'password',
		'status',
	];

	protected $hidden = ['password', 'token'];

	public function scopeUserDocs($q) {
		return $q->From('users AS u')
			->select('u.id AS user_id', 'files.id AS file_id', 'files.doc_id', 'files.name AS filename', 'files.original_name', 'files.path', 'files.size', 'files.extension', 'files.status AS file_status', 'files.updated_at AS file_updated_at', 'folders.id AS folder_id', 'folders.folder_uid', 'folders.name AS folder_name', 'folders.parent', 'folders.status AS folder_status', 'folders.updated_at AS folder_updated_at')
			->leftJoin('files', 'files.user_id', '=', 'u.id')
			->leftJoin('folders', 'folders.user_id', '=', 'u.id');

	}

	public function folders() {
		return $this->hasMany(Folder::class, 'user_id')->where('folders.status', '1');
	}

	public function files() {
		return $this->hasMany(Docs::class, 'user_id')->where('files.status', '1');
	}

	public function trash_folders() {
		return $this->hasMany(Folder::class, 'user_id')->where('folders.status', '2');
	}

	public function trash_files() {
		return $this->hasMany(Docs::class, 'user_id')->where('files.status', '2');
	}

}
