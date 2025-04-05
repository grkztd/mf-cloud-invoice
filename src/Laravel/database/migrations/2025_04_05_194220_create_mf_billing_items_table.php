<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMfBillingItemsTable extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('mf_billing_items', function(Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('billing_id');
            $table->string('item_id')->unique();
            $table->string('name');
            $table->string('code', 100)->nullable();
            $table->text('detail')->nullable();
            $table->string('unit', 50)->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->boolean('is_deduct_withholding_tax')->nullable();
            $table->enum('excise', [
                'untaxable',
                'non_taxable',
                'tax_exemption',
                'five_percent',
                'eight_percent',
                'eight_percent_as_reduced_tax_rate',
                'ten_percent'
            ])->nullable();
            $table->string('delivery_number', 100)->nullable();
            $table->date('delivery_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('mf_billing_items');
    }
}
