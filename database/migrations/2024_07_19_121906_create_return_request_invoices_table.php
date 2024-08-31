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
        Schema::create('return_request_invoices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('return_request_id')->nullable();
            $table->foreign('return_request_id')->references('id')->on('return_requests');
            
            $table->boolean("requires_invoice")->comment("Saber si requiere factura");
            $table->string("invoice")->nullable()->comment("Factura");

            $table->unsignedBigInteger('client_business_id')->nullable();
            $table->foreign('client_business_id')->references('id')->on('client_businesses');

            $table->unsignedBigInteger('promotor_id')->nullable();
            $table->foreign('promotor_id')->references('id')->on('promotors');

            //Por default se crea con el status 1 --por operar
            $table->unsignedTinyInteger('return_request_status_id')->default(1); //Default incompelta
            $table->foreign('return_request_status_id')->references('id')->on('return_request_statuses');

            //Cuanto es operada por caballero. Esta es para saber a donde se regresará el dinero por parte de caballero
            $table->unsignedBigInteger('account_destiny_id')->nullable()->comment("Cuenta donde se recibirá el dinero por parte de caballero");
            $table->foreign('account_destiny_id')->references('id')->on('accounts');

            $table->unsignedTinyInteger('payment_method_id')->nullable();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');

            $table->unsignedTinyInteger('payment_way_id')->nullable();
            $table->foreign('payment_way_id')->references('id')->on('payment_ways');

            $table->unsignedTinyInteger('cfdi_use_id')->nullable();
            $table->foreign('cfdi_use_id')->references('id')->on('cfdi_uses');
             
            $table->string("origin_account")->nullable()->comment("Cuenta de origin en datos de facturación");

            $table->float("subtotal")->nullable()->comment("Subtotal");
            $table->float("iva")->nullable()->comment("IVA");
            $table->float("total_invoice")->nullable()->comment("Total de la factura");

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
        Schema::dropIfExists('return_requests');
    }
};
