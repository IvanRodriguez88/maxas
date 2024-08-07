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
        Schema::table('accounts', function (Blueprint $table) {
            $table->decimal('balance', 12, 2)->change();
        });

        Schema::table('promotors', function (Blueprint $table) {
            $table->decimal('balance', 12, 2)->change();
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->decimal('balance', 12, 2)->change();
        });

        Schema::table('return_requests', function (Blueprint $table) {
            $table->decimal('total_return', 12, 2)->change();
            $table->decimal("total_return", 12, 2)->change();
            $table->decimal("comission_charged", 12, 2)->change();
            $table->decimal("social_cost", 12, 2)->change();
            $table->decimal("comission_promotor", 12, 2)->change();
            $table->decimal("comission_intermediary", 12, 2)->change();
            $table->decimal("comission_play", 12, 2)->change();
            $table->decimal("play_return", 12, 2)->change();
            $table->decimal("return_percentage", 12, 2)->change();
            $table->decimal("return_percentage_promotor", 12, 2)->change();
            $table->decimal("return_percentage_play", 12, 2)->change();
            $table->decimal("return_percentage_intermediary", 12, 2)->change();
            $table->decimal("subtotal", 12, 2)->change();
            $table->decimal("iva", 12, 2)->change();
            $table->decimal("total_invoice", 12, 2)->change();

        });

        Schema::table('return_request_return_types', function (Blueprint $table) {
            $table->decimal('amount', 12, 2)->change();
        });

        Schema::table('return_request_concepts', function (Blueprint $table) {
            $table->decimal('unit_price', 12, 2)->change();
            $table->decimal('total', 12, 2)->change();
        });

    }
 
};
