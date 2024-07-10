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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('rfc');
            $table->string('street_and_number');
            $table->string('cologne');
            $table->string('state');
            $table->string('city');
            $table->string('postal_code');

            $table->float('comission_ban')->comment("Comisión de bancarizacion del promotor en %");
            $table->float('comission_flu')->comment("Comisión de flujo del promotor en %");
            $table->float('comission_nom')->comment("Comisión de nominas del promotor en %");

            $table->unsignedTinyInteger('client_type_id')->nullable();
            $table->foreign('client_type_id')->references('id')->on('client_types');

            $table->unsignedBigInteger('promotor_id')->nullable();
            $table->foreign('promotor_id')->references('id')->on('promotors');

            $table->unsignedTinyInteger('return_base_id')->nullable();
            $table->foreign('return_base_id')->references('id')->on('return_bases');

            //Comisiones que el promotor cobra al cliente
            $table->float('comission_ban_promotor')->nullable()->comment("Comisión de bancarizacion que el promotor cobra al cliente en %");
            $table->float('comission_flu_promotor')->nullable()->comment("Comisión de flujo que el promotor cobra al cliente en %");
            $table->float('comission_nom_promotor')->nullable()->comment("Comisión de nominas que el promotor cobra al cliente en %");

            //Usuario ligado a este cliente
            $table->unsignedSmallInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('clients');
    }
};
