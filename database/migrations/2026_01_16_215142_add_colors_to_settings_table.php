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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('news_ticker_bg_color')->nullable()->default('#222222');
            $table->string('news_ticker_text_color')->nullable()->default('#ffffff');
            $table->string('primary_color')->nullable()->default('#e74c3c');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['news_ticker_bg_color', 'news_ticker_text_color', 'primary_color']);
        });
    }
};
