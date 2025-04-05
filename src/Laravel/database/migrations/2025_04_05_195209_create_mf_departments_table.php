<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMfDepartmentsTable extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('mf_departments', function(Blueprint $table) {
            $table->char('id', 26);
            $table->string('department_id');
            $table->string('partner_id');
            $table->string('zip', 20)->nullable();
            $table->string('tel', 20)->nullable();
            $table->string('prefecture')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('person_name')->nullable();
            $table->string('person_title')->nullable();
            $table->string('person_dept')->nullable();
            $table->string('email')->nullable();
            $table->text('cc_emails')->nullable();
            $table->string('peppol_id')->nullable();
            $table->string('office_member_id')->nullable();
            $table->string('office_member_name')->nullable();
            $table->timestamps(0); // Created at and Updated at columns

            $table->unique('department_id');
            $table->index('partner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('mf_departments');
    }
}
