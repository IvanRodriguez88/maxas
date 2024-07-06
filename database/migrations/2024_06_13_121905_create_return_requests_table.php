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
        Schema::create('return_requests', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');

            $table->unsignedBigInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');

            $table->unsignedBigInteger('account_id')->nullable();
            $table->foreign('account_id')->references('id')->on('accounts');

            $table->unsignedBigInteger('promotor_id')->nullable();
            $table->foreign('promotor_id')->references('id')->on('promotors');
            
            $table->date("date")->comment("Fecha de creación (posible modificación)");
            $table->string("invoice")->unique()->nullable()->comment("Factura");

            $table->unsignedTinyInteger('return_base_id')->nullable();
            $table->foreign('return_base_id')->references('id')->on('return_bases');

            //Cuanto es operada por caballero. Esta es para saber a donde se regresará el dinero por parte de caballero
            $table->unsignedBigInteger('account_destiny_id')->nullable()->comment("Cuenta donde se recibirá el dinero por parte de caballero");
            $table->foreign('account_destiny_id')->references('id')->on('accounts');

            //Por default se crea con el status 1 --por operar
            $table->unsignedTinyInteger('return_request_status_id')->default(1);
            $table->foreign('return_request_status_id')->references('id')->on('return_request_statuses');

            $table->float("total_return")->nullable()->comment("Total a retornar");
            $table->float("comission_charged")->nullable()->comment("Comisión cobrada");
            $table->float("iva")->nullable()->comment("IVA");
            $table->float("social_cost")->nullable()->comment("Costo social");
            $table->float("comission_promotor")->nullable()->comment("Comisión de promotor");
            $table->float("comission_cab")->nullable()->comment("Comisión de caballero");
            $table->float("comission_play")->nullable()->comment("Comisión de play");

            $table->float("play_return")->nullable()->comment("Retorno play");
            $table->float("cab5T")->nullable()->comment("Cab .5% sobre t");
            $table->tinyInteger("return_percentage")->nullable()->comment("Cab .5% sobre t");
            $table->float("total_invoice")->nullable()->comment("Total de la factura");

            $table->string("client_payment_proof")->nullable()->comment("Archivo comprobante de pago");

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
