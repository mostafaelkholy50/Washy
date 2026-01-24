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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->text('welcome_title')->nullable(); // For the welcome note section
            // Welcome Section Buttons
            $table->string('welcome_btn_1_text')->nullable()->default('رؤية الاعمال');
            $table->string('welcome_btn_1_link')->nullable()->default('#');
            $table->string('welcome_btn_2_text')->nullable()->default('اتصل بنا');
            $table->string('welcome_btn_2_link')->nullable()->default('#');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
