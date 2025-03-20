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
        Schema::table('super_admins', function (Blueprint $table) {
            $table->string('company_bank_account')->nullable();
            $table->unsignedBigInteger('company_bank_id')->nullable();
            $table->foreign('company_bank_id')->references('id')->on('banks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('super_admins', function (Blueprint $table) {
            $table->dropForeign(['company_bank_id']);
            $table->dropColumn('company_bank_id');
            $table->dropColumn('company_bank_account');
        });
    }
};
