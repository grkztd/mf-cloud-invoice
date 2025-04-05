<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMfPartnersTable extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('mf_partners', function(Blueprint $table) {
            $table->char('id', 26);
            $table->string('partner_id');
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('name_kana')->nullable();
            $table->string('name_suffix')->nullable();
            $table->text('memo')->nullable();
            $table->timestamps(0); // Created at and Updated at columns

            $table->unique('partner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('mf_partners');
    }
}
