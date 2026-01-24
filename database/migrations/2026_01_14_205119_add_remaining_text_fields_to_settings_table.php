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
            $table->string('skills_title')->nullable()->default('مهارات الفريق');
            $table->text('skills_description')->nullable();
            
            $table->string('services_title')->nullable()->default('خدماتنا');
            $table->text('services_description')->nullable();
            $table->string('services_sub_title')->nullable()->default('ماذا نفعل ؟');
            $table->text('services_sub_description')->nullable();

            $table->string('portfolio_title')->nullable()->default('معرض اعمالنا');
            $table->text('portfolio_description')->nullable();

            $table->string('blog_title')->nullable()->default('مدونتنا');
            $table->text('blog_description')->nullable();

            $table->string('contact_title')->nullable()->default('اتصل بنا');
            $table->text('contact_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
