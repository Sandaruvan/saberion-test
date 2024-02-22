<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 12)->unique();
            $table->string('category', 40);
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->unsignedDecimal('selling_price', 13, 2);
            $table->unsignedDecimal('special_price', 13, 2)->nullable();
            $table->enum('status', ['draft', 'published', 'out_of_stock'])->default('draft');
            $table->boolean('is_delivery_available')->default(true);
            $table->string('image')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('edited_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
