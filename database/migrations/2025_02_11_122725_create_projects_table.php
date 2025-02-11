<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_category');
            $table->string('project_type')->nullable();
            $table->string('project_code');
            $table->string('name');
            $table->foreignId('merp_id')->nullable();
            $table->string('funding_source')->nullable();
            $table->float('funds_received', 12, 2)->nullable();
            $table->float('funding_amount', 12, 2)->nullable();
            $table->foreignId('currency_id')->nullable()->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->longText('project_summary')->nullable();
            $table->string('progress_status');
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
