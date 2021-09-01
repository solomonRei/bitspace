<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugColumnToTagsStringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags_strings', function (Blueprint $table) {
            $table->string('slug');
        });

        Schema::table('tags_strings', function (Blueprint $table) {
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tags_strings', function (Blueprint $table) {
            $table->dropIndex('tags_strings_slug_index');
            $table->dropColumn('slug');
        });
    }
}
