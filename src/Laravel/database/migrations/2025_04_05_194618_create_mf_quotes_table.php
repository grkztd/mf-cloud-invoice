<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMfQuotesTable extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('mf_quotes', function(Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('quote_id')->unique();
            $table->text('pdf_url');
            $table->string('operator_id');
            $table->string('department_id');
            $table->string('member_id');
            $table->string('member_name');
            $table->string('partner_id');
            $table->string('partner_name');
            $table->text('partner_detail')->nullable();
            $table->string('office_id')->nullable();
            $table->string('office_name');
            $table->text('office_detail');
            $table->string('title');
            $table->text('memo')->nullable();
            $table->date('quote_date');
            $table->string('quote_number')->nullable();
            $table->text('note')->nullable();
            $table->date('expired_date');
            $table->string('document_name')->nullable();
            $table->enum('order_status', ['failure', 'default', 'not_received', 'received'])->default('default');
            $table->enum('transmit_status', ['default', 'sent', 'already_read', 'received'])->default('default');
            $table->enum('posting_status', ['default', 'request', 'sent', 'cancel', 'error'])->default('default');
            $table->boolean('is_downloaded')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->decimal('deduct_price', 15, 2)->nullable();
            $table->decimal('excise_price', 15, 2);
            $table->decimal('excise_price_of_untaxable', 15, 2)->nullable();
            $table->decimal('excise_price_of_non_taxable', 15, 2)->nullable();
            $table->decimal('excise_price_of_tax_exemption', 15, 2)->nullable();
            $table->decimal('excise_price_of_five_percent', 15, 2)->nullable();
            $table->decimal('excise_price_of_eight_percent', 15, 2)->nullable();
            $table->decimal('excise_price_of_eight_percent_as_reduced_tax_rate', 15, 2)->nullable();
            $table->decimal('excise_price_of_ten_percent', 15, 2)->nullable();
            $table->decimal('subtotal_price', 15, 2);
            $table->decimal('subtotal_of_untaxable_excise', 15, 2)->nullable();
            $table->decimal('subtotal_of_non_taxable_excise', 15, 2)->nullable();
            $table->decimal('subtotal_of_tax_exemption_excise', 15, 2)->nullable();
            $table->decimal('subtotal_of_five_percent_excise', 15, 2)->nullable();
            $table->decimal('subtotal_of_eight_percent_excise', 15, 2)->nullable();
            $table->decimal('subtotal_of_eight_percent_as_reduced_tax_rate_excise', 15, 2)->nullable();
            $table->decimal('subtotal_of_ten_percent_excise', 15, 2)->nullable();
            $table->decimal('total_price', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('mf_quotes');
    }
}
