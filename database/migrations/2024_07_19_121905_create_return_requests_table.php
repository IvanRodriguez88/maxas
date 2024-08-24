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
            
            $table->datetime("date")->nullable()->comment("Fecha de creación (posible modificación)");

            //Se le pone cual es para que se registre con cual se hizo
            $table->unsignedTinyInteger('return_base_id')->nullable();
            $table->foreign('return_base_id')->references('id')->on('return_bases');

            $table->unsignedTinyInteger('request_type_id')->nullable();
            $table->foreign('request_type_id')->references('id')->on('request_types');

            //Por default se crea con el status 1 --por operar
            $table->unsignedTinyInteger('return_request_status_id')->default(1); //Default incompelta
            $table->foreign('return_request_status_id')->references('id')->on('return_request_statuses');

            $table->float("total_return")->nullable()->comment("Total a retornar");
            $table->float("comission_charged")->nullable()->comment("Comisión cobrada");
            $table->float("social_cost")->nullable()->comment("Costo social");
            $table->float("comission_promotor")->nullable()->comment("Comisión de promotor");
            $table->float("comission_intermediary")->nullable()->comment("Comisión de caballero");
            $table->float("comission_play")->nullable()->comment("Comisión de play");

            $table->float("play_return")->nullable()->comment("Retorno play");
            $table->float("return_percentage")->nullable()->comment("Porcentaje de retorno total");
            $table->float("return_percentage_promotor")->nullable()->comment("Porcentaje de retorno para promotor");
            $table->float("return_percentage_play")->nullable()->comment("Porcentaje de retorno para play");
            $table->float("return_percentage_intermediary")->default(.5)->nullable()->comment("Porcentaje de retorno para caballero");

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
