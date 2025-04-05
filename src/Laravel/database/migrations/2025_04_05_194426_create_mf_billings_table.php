<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMfBillingsTable extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('mf_billings', function(Blueprint $table) {
            $table->char('id', 26)->primary();
            $table->string('billing_id')->unique();
            $table->text('pdf_url');
            $table->string('operator_id');
            $table->string('department_id');
            $table->string('member_id');
            $table->string('member_name')->nullable();
            $table->string('partner_id');
            $table->string('partner_name');
            $table->string('office_id')->nullable();
            $table->string('office_name');
            $table->text('office_detail');
            $table->string('title');
            $table->text('memo')->nullable();
            $table->text('payment_condition')->nullable();
            $table->date('billing_date');
            $table->date('due_date');
            $table->date('sales_date')->nullable();
            $table->string('billing_number')->nullable();
            $table->text('note')->nullable();
            $table->string('document_name')->nullable();
            $table->enum('payment_status', ['未設定', '未入金', '入金済み', '未払い', '振込済み'])->default('未設定');
            $table->enum('email_status', ['未送信', '送付済み', '受領済み', '受信'])->default('未送信');
            $table->enum('posting_status', ['未郵送', '郵送依頼', '郵送済み', '郵送取消', '郵送失敗'])->default('未郵送');
            $table->boolean('is_downloaded')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->decimal('deduct_price', 15, 2)->nullable();
            $table->string('delivery_number')->nullable();
            $table->date('delivery_date')->nullable();
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
            $table->decimal('subtotal_with_tax_of_untaxable_excise', 15, 2)->nullable();
            $table->decimal('subtotal_with_tax_of_non_taxable_excise', 15, 2)->nullable();
            $table->decimal('subtotal_with_tax_of_tax_exemption_excise', 15, 2)->nullable();
            $table->decimal('subtotal_with_tax_of_five_percent_excise', 15, 2)->nullable();
            $table->decimal('subtotal_with_tax_of_eight_percent_excise', 15, 2)->nullable();
            $table->decimal('subtotal_with_tax_of_eight_percent_as_reduced_tax_rate_excise', 15, 2)->nullable();
            $table->decimal('subtotal_with_tax_of_ten_percent_excise', 15, 2)->nullable();
            $table->decimal('total_price', 15, 2);
            $table->string('registration_code')->nullable();
            $table->boolean('use_invoice_template');
            $table->enum('rounding', ['round_down', 'round_up', 'round_off']);
            $table->enum('rounding_consumption_tax', ['round_down', 'round_up', 'round_off']);
            $table->enum('consumption_tax_display_type', ['internal', 'external']);
            $table->json('tag_names')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('mf_billings');
    }
}
