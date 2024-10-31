<?php

use App\Models\Bank;
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
            $table->unsignedBigInteger('bank_company_id')->nullable();
            $table->foreign('bank_company_id')->references('id')->on('banks')->cascadeOnDelete();
            $table->string('bank_company_account')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('super_admins', function (Blueprint $table) {
            $table->dropForeign(['bank_company_id']);
            $table->dropColumn('bank_company_account');
            $table->dropColumn('bank_company_id');
        });
    }
};
