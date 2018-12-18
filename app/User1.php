<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function scopeUserDocs($q) {
		return $q->From('users AS u')
			->select('u.id AS user_id', 'files.id AS file_id', 'files.doc_id', 'files.name AS filename', 'files.original_name', 'files.path', 'files.size', 'files.extension', 'files.status AS file_status', 'files.updated_at AS file_updated_at', 'folders.id AS folder_id', 'folders.folder_uid', 'folders.name AS folder_name', 'folders.parent', 'folders.status AS folder_status', 'folders.updated_at AS folder_updated_at')
			->leftJoin('files', 'files.user_id', '=', 'u.id')
			->leftJoin('folders', 'folders.user_id', '=', 'u.id');

	}

/*'files.id AS file_id','files.doc_id','files.name AS filename','files.original_name','files.user_id','files.folder_id','files.path','files.size','files.extension','files.status','files.created_at','files.updated_at',

'folders.id AS folder_id', 'folders.folder_uid', 'folders.name AS folder_name', 'folders.user_id', 'folders.parent', 'folders.status', 'folders.created_at', 'folders.updated_at', */
}
