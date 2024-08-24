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
        Schema::create('return_request_files', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('return_request_invoice_company_id')->nullable();
            $table->foreign('return_request_invoice_company_id')->references('id')->on('return_request_invoice_companies');

            $table->string("client_payment_proof")->nullable()->comment("Archivo comprobante de pago");
            $table->boolean('in_bank')->default(0)->comment('Confirma si llegó en el banco');

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
