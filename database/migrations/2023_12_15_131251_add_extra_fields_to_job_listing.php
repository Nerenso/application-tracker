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
        Schema::table('job_listings', function (Blueprint $table) {
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('salary_from')->nullable();
            $table->unsignedBigInteger('salary_to')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string("contact_email")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('job_listings', function (Blueprint $table) {
        //     $table->dropColumn()
        // });

        Schema::dropColumns('job_listings', ['notes', 'salary_from', 'salary_to', 'contact_name', 'contact_phone', 'contact_email']);
    }
};
