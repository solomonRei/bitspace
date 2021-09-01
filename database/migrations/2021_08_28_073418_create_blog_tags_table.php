<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tags_strings', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->change();
        });

        Schema::create('blog_tags', function (Blueprint $table) {
            $table->id();
            $table->integer('blog_id');
            $table->integer('tag_id');
        });

        Schema::table('blog_tags', function (Blueprint $table) {
            $table->foreign('blog_id')->references('id')->on('blogs')->cascadeOnDelete();
            $table->foreign('tag_id')->references('id')->on('tags_strings')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_tags', function (Blueprint $table) {
            $table->dropForeign('blog_tags_blog_id_foreign');
            $table->dropForeign('blog_tags_tag_id_foreign');
        });
        Schema::dropIfExists('blog_tags');
    }
}
