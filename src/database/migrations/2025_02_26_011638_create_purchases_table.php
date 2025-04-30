<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->decimal('total_price', 10, 2);
            $table->foreignId('profile_id')->nullable()->constrained()->onDelete('set null');
            $table->string('payment_method');
            $table->string('status')->default('trading');
            $table->boolean('seller_completed')->default(false);
            $table->boolean('buyer_completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
