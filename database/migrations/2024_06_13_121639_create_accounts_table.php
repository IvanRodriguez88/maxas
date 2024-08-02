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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();

            $table->unsignedSmallInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks');

            $table->unsignedTinyInteger('currency_type_id')->nullable();
            $table->foreign('currency_type_id')->references('id')->on('currency_types');
            
            $table->unsignedTinyInteger('bank_separation_id')->nullable();
            $table->foreign('bank_separation_id')->references('id')->on('bank_separations');

            $table->string('account_number')->nullable();
            $table->string('clabe')->nullable();
            $table->string('ava')->nullable();
            $table->string('swift')->nullable();
            $table->float('balance')->default(0)->comment("Saldo de la cuenta");

            $table->timestamps();

            $table->string('notes', 1024)->nullable()->comment('Notas');    
            $table->boolean('is_active')->default(1)->comment('Muestra si la fila está activa');
            $table->smallInteger('created_by')->unsigned()->nullable()->comment('Usuario que creó');
            $table->foreign('created_by')->references('id')->on('users');
            $table->smallInteger('updated_by')->unsigned()->nullable()->comment('Último usuario que modificó');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
