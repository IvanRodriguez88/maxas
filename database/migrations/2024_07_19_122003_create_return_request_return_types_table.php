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
        Schema::create('return_request_return_types', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('return_request_id')->nullable();
            $table->foreign('return_request_id')->references('id')->on('return_requests');

            $table->string("beneficiary_name")->comment("Nombre del beneficiario");

            $table->unsignedSmallInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks');

            $table->unsignedTinyInteger('return_type_id')->nullable();
            $table->foreign('return_type_id')->references('id')->on('return_types');

            $table->string("account_number")->comment("Cuenta bancaria o clabe interbancaria o donde recoge");
            $table->float("amount")->comment("Monto");
            $table->string("reference")->nullable()->comment("Referencia");

            $table->string("dispersion_voucher_file")->nullable()->comment("Comprobante de dispersión");

			$table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts')->comment("Cuenta desde donde se dispersó");

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
        Schema::dropIfExists('return_request_return_types');
    }
};
