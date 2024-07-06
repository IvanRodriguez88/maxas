c<?php

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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->unsignedTinyInteger('group_id')->nullable();
            $table->foreign('group_id')->references('id')->on('groups');

            $table->unsignedTinyInteger('bank_separation_id')->nullable();
            $table->foreign('bank_separation_id')->references('id')->on('bank_separations');

            $table->unsignedTinyInteger('account_status_id')->nullable();
            $table->foreign('account_status_id')->references('id')->on('account_statuses');

            $table->unsignedTinyInteger('intermediary_id')->nullable();
            $table->foreign('intermediary_id')->references('id')->on('intermediaries');

            $table->unsignedTinyInteger('company_level_id')->nullable();
            $table->foreign('company_level_id')->references('id')->on('company_levels');

            $table->string('name');    
            $table->string('social_object', 1024);    
            $table->float('comission');    

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
        Schema::dropIfExists('companies');
    }
};
