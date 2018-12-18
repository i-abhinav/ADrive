<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoldersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('folders', function (Blueprint $table) {
			$table->increments('id');
			$table->string('folder_uid', 30)->collation('utf8_unicode_ci');
			$table->string('name');
			$table->integer('user_id');
			$table->integer('parent')->nullable();
			$table->char('status', 1);
			$table->dateTime('created_at');
			$table->dateTime('updated_at');
			$table->unique('folder_uid');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('folders');
	}
}
