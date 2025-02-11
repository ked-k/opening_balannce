<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('fms_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code', 50)->unique();
            $table->boolean('is_active')->default(true);
            $table->boolean('system_default')->default(false);
            $table->float('exchange_rate')->default(1);
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });

        DB::statement("
            INSERT INTO `fms_currencies` (`id`, `name`, `code`, `is_active`, `system_default`, `exchange_rate`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
            (1, 'Uganda Shillings', 'UGX', 1, 1, 1.00, NULL, NULL, '2023-08-02 23:24:27', '2024-04-02 18:51:00'),
            (2, 'US Dollars ', 'USD', 1, 0, 3684.73, NULL, NULL, '2024-01-24 22:27:43', '2025-01-17 16:24:27'),
            (3, 'EURO', 'EURO', 1, 0, 3791.59, NULL, NULL, '2024-01-24 22:28:29', '2025-01-17 16:24:55'),
            (4, 'Great British Pound', 'GBP', 1, 0, 4939.18, NULL, NULL, '2024-03-19 17:09:44', '2024-09-20 20:19:48'),
            (5, 'South African Rand', 'ZAR', 1, 0, 202.95, NULL, NULL, '2024-04-11 23:58:51', '2024-04-17 04:56:18');
        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fms_currencies');
    }
};
