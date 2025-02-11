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
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('slogan')->nullable();
            $table->text('about')->nullable();
            $table->string('company_type')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('address2')->nullable();
            $table->string('contact')->nullable();
            $table->string('alt_contact')->nullable();
            $table->string('email')->nullable();
            $table->string('alt_email')->nullable();
            $table->string('tin')->nullable();
            $table->string('website')->nullable();
            $table->string('fax')->nullable();
            $table->string('logo')->nullable();
            $table->string('logo2')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('company_profiles');
    }
};
