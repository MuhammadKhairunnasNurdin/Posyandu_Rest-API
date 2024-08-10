<?php

use App\Enum\Article\TagEnum;
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
        Schema::create('articles', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id');
            $table->string('title', 100);
            $table->text('body');
            $table->string('excerpt', 200);
            $table->enum('tag', TagEnum::getValues());
            $table->string('photo_article', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
