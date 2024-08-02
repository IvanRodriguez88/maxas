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
        Schema::create('return_request_concepts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('return_request_id')->nullable();
            $table->foreign('return_request_id')->references('id')->on('return_requests');

            $table->smallInteger("amount");

            $table->unsignedTinyInteger('unit_type_id')->nullable();
            $table->foreign('unit_type_id')->references('id')->on('unit_types');

            $table->string("concept");
            $table->string("description");
            $table->float("unit_price");
            $table->float("total");

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
        Schema::dropIfExists('return_request_concepts');
    }
};
