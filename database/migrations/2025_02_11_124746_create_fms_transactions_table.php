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
        Schema::create('fms_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trx_no')->unique();
            $table->string('trx_ref')->nullable();
            $table->text('client')->nullable();
            $table->date('trx_date');
            $table->double('total_amount', 16, 2)->default(0.00);
            $table->double('amount_local', 16, 2)->default(0.00);
            $table->double('deductions', 16, 2)->default(0.00);
            $table->double('rate')->default(1.00);
            $table->foreignId('project_id')->nullable()->constrained('projects', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('currency_id')->nullable()->references('id')->on('fms_currencies')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('ledger_account')->nullable();
            $table->foreignId('expense_type_id')->nullable()->constrained('expense_types', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->enum('trx_type', ['Income', 'Expense', 'Transfer'])->default('Expense');
            $table->enum('entry_type', ['OP'])->default('OP');
            $table->enum('status', ['Paid', 'Pending', 'Approved', 'Canceled'])->default('Pending');
            $table->tinyText('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users', 'id')->onUpdate('cascade')->onDelete('restrict');
            $table->morphs('requestable');
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
        Schema::dropIfExists('fms_transactions');
    }
};
