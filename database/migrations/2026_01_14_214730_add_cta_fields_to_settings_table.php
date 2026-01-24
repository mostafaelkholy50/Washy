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
            $table->text('cta_text')->nullable();
            $table->string('cta_button1_text')->nullable();
            $table->string('cta_button1_link')->nullable();
            $table->string('cta_button2_text')->nullable();
            $table->string('cta_button2_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['cta_text', 'cta_button1_text', 'cta_button1_link', 'cta_button2_text', 'cta_button2_link']);
        });
    }
};
