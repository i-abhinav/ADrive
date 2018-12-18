<?php

namespace App\Models;

class Rules {

	public static $userStatus = [
		'1' => 'Active',
		'2' => 'Inactive',
		'3' => 'unverified',
	];

	public static $fileStatus = [
		'1' => 'Active',
		'2' => 'Trash',
		'3' => 'Dormant',
	];

	//Validating Rules
	public static $signup = [
		'name' => 'required|regex:/^[a-zA-Z0-9]+(\s[a-zA-Z0-9]+)*$/|min:2|max:100',
		'email' => 'required|email|unique:users,email',
		// 'mobile' => 'required|digits:10|numeric',
		'password' => 'required|min:6|max:50|confirmed',
	];

	public static $docRules = [
		// 'document_name' => 'required|min:2|max:100|alpha_tap',
		'document_name' => 'required|min:2|max:100',
		'document_number' => 'required|min:2|max:100',
		'document_path' => 'required|max:2000|mimes:jpg,jpeg,png,pdf,gif,doc,docx,xls,xlxs,xlsx,txt,csv', //size:2MB
	];

	public static $allowedDocExtenssion = ['jpg', 'jpeg', 'png', 'pdf', 'gif', 'doc', 'docx', 'xls', 'xlxs', 'xlsx', 'txt', 'csv'];

	public static function formatSizeUnits($bytes = null) {
		if (empty($bytes)) {
			return "--";
		}
		if ($bytes >= 1073741824) {
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		} elseif ($bytes >= 1048576) {
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		} elseif ($bytes >= 1024) {
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		} elseif ($bytes > 1) {
			$bytes = $bytes . ' bytes';
		} elseif ($bytes == 1) {
			$bytes = $bytes . ' byte';
		} else {
			$bytes = '0 bytes';
		}

		return $bytes;
	}

}
