<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('company', 100);
            $table->text('description')->nullable();
            $table->foreignId('phase_id')->constrained()->onUpdate('cascade');
            $table->date('application_date')->default(now());
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
        Schema::dropIfExists('work_applications');
    }
}
