<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new \App\Models\Order())->getTable(), static function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->float('price')->nullable(false);
            $table->timestamp('created_at')->useCurrent();
            //Relation to another table is better
            $table->char('status', 1)->default(Order::STATUS['NEW']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists((new \App\Models\Order())->getTable());
    }
}
