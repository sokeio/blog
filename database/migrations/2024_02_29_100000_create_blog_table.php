<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('slug', 500);
            $table->string('description', 400)->nullable();
            $table->longText('content')->nullable();
            $table->string('status', 60)->default('published');
            $table->integer('author_id');
            $table->tinyInteger('is_featured')->unsigned()->default(0);
            $table->string('image', 255)->nullable();
            $table->string('view_layout')->nullable();
            $table->string('format_type', 30)->nullable();
            $table->string('layout', 255)->nullable();
            $table->datetime('published_at')->nullable();
            $table->longText('data')->nullable();
            $table->text('js')->nullable();
            $table->text('css')->nullable();
            $table->text('custom_js')->nullable();
            $table->text('custom_css')->nullable();
            $table->timestamps();
        });

        Schema::create('catalogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('slug', 500);
            $table->integer('parent_id')->unsigned()->default(0);
            $table->string('description', 400)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('view_layout')->nullable();
            $table->string('status', 60)->nullable()->default('published');
            $table->integer('author_id');
            $table->string('icon', 60)->nullable();
            $table->tinyInteger('order')->default(0);
            $table->tinyInteger('is_featured')->nullable()->default(0);
            $table->tinyInteger('is_default')->nullable()->unsigned()->default(0);
            $table->string('layout', 255)->nullable();
            $table->longText('data')->nullable();
            $table->timestamps();
        });
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 500);
            $table->string('image', 255)->nullable();
            $table->string('view_layout')->nullable();
            $table->integer('author_id');
            $table->string('description', 400)->nullable()->default('');
            $table->string('status', 60)->nullable()->default('published');
            $table->timestamps();
        });
        Schema::create('post_tags', function (Blueprint $table) {
            $table->id();
            $table->integer('tag_id')->unsigned()->index();
            $table->integer('post_id')->unsigned()->index();
        });

        Schema::create('post_catalogs', function (Blueprint $table) {
            $table->id();
            $table->integer('catalog_id')->unsigned()->index();
            $table->integer('post_id')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_catalogs');
        Schema::dropIfExists('post_tags');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('catalogs');
        Schema::dropIfExists('posts');
    }
};
