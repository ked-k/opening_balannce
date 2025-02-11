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
        Schema::create('project_mous', function (Blueprint $table) {
            $table->id();
            $table->float('funding_amount', 12, 2)->nullable();
            $table->foreignId('project_id')->nullable()->references('id')->on('projects')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->date('start_date');
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('project_mous');
    }
};
