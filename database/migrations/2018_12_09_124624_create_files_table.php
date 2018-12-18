<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('files', function (Blueprint $table) {
			$table->increments('id');
			$table->string('doc_id', 50)->collation('utf8_unicode_ci');
			$table->string('name');
			$table->text('original_name')->nullable();
			$table->integer('user_id');
			$table->integer('folder_id')->nullable();
			$table->string('path')->nullable();
			$table->string('size')->nullable();
			$table->string('extension')->nullable();
			$table->string('mime')->nullable();
			$table->char('status', 1);
			$table->dateTime('created_at');
			$table->dateTime('updated_at');
			$table->unique('doc_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('files');
	}
}
