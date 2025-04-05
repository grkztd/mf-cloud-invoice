<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMfQuoteItemsTable extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('mf_quote_items', function(Blueprint $table) {
            $table->char('id', 26);
            $table->string('quote_id');
            $table->string('item_id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->text('detail')->nullable();
            $table->string('unit', 50)->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('quantity', 10, 2)->nullable();
            $table->enum('excise', [
                'untaxable', 'non_taxable', 'tax_exemption',
                'five_percent', 'eight_percent',
                'eight_percent_as_reduced_tax_rate', 'ten_percent'
            ]);
            $table->timestamps(0); // Created at and Updated at columns

            $table->primary('id');
            $table->unique('item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('mf_quote_items');
    }
}
