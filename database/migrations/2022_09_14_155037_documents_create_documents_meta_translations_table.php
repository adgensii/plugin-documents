<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents_meta_translations', function (Blueprint $table) {
            $table->string('lang_code');
            $table->integer('documents_meta_id');
            $table->text('documents')->nullable();

            $table->primary(['lang_code', 'documents_meta_id'], 'documents_meta_translations_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents_meta_translations');
    }
};
