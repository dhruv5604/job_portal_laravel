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
        Schema::table('job_posts', function (Blueprint $table) {
            $table->renameColumn('comapany_location', 'company_location');
            $table->renameColumn('comapany_name', 'company_name');
            $table->renameColumn('comapany_website', 'company_website');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->renameColumn('company_location', 'comapany_location');
            $table->renameColumn('company_name', 'comapany_name');
            $table->renameColumn('company_website', 'comapany_website');
        });
    }
};
