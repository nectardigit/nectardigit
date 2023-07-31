<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();

            $table->text('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->text('tagLine')->nullable();
            $table->longText('summary')->nullable();
            $table->longText('description')->nullable();

            $table->text('category')->nullable();
            $table->text('reporters')->nullable();

            $table->string('byLine')->nullable();
            $table->unsignedBigInteger('userId')->nullable()->comment('from old table ');
            $table->text('video')->nullable();

            $table->string('image')->nullable();


            $table->unsignedBigInteger('oldId')->nullable();


            $table->enum('isOldData', ['0', '1'])->default('0');
            $table->text('tags')->nullable();


            $table->string('news_language', 30)->nullable();

            $table->unsignedBigInteger('reporter')->nullable();
            $table->text('guest')->nullable();
            $table->unsignedBigInteger('guestId')->nullable();
            $table->enum('publish_status', ['0','1','2'])->default('1')->index();
            $table->integer('image_show')->nullable();

            $table->text('image_caption')->nullable();
            $table->enum('mobile_notification', ['0', '1'])->default('0');
            $table->enum('postType', ['news', 'blog', 'talks', 'article'])->default('news');
            $table->unsignedBigInteger('view_count')->default(0);
            $table->text('meta_title')->nullable();
            $table->text('meta_keyword')->nullable();

            $table->text('meta_description')->nullable();
            $table->text('meta_keyphrase')->nullable();
            $table->string('text_position')->nullable()->default(null);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->unsignedBigInteger('verified_by')->nullable();
            $table->text('img_url')->nullable();

            $table->string('feature_img_url')->nullable();
            $table->dateTimeTz('published_at')->nullable()->index();
            $table->dateTimeTz('verified_at')->nullable();


            $table->boolean('isBanner')->default(false);
            $table->boolean('isSpecial')->default(false)->index();
            $table->boolean('isPhotoFeature')->default(false);


            $table->string('showReporter', 20)->default("0");
            $table->string('showContent', 20)->default("0");
            $table->string('isFlashNews', 20)->default("0");
            $table->string('flashNewsOrder', 20)->default("0");
            $table->string('isVideo', 20)->default("0");
            $table->string('isFixed', 20)->default("0");
            $table->string('isBreaking', 20)->default("0");
            $table->integer('breakingNewsOrder')->default(1);
            $table->integer('publish')->nullable()->index();
            $table->softDeletes()->index();
            $table->timestamps();
            // $table->foreign('reporter')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('SET NULL')->onUpdate('CASCADE');
        });
        DB::update("ALTER TABLE news AUTO_INCREMENT= 10000;");
        // ALTER TABLE `news` ADD `img_url` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `updated_at`, ADD `img_name` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `img_url`, ADD `img_extension` VARCHAR(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `img_name`, ADD `img_path` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `img_extension`, ADD `folder_path` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `img_path`;

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
