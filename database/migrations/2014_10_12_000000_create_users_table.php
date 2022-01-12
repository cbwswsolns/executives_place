<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company_name')->nullable();
            $table->string('job_title');
            $table->string('phone');
            $table->string('email')->unique();
            /* CBW Note: float as DOUBLE[8, 2] is sufficent for an hourly rate
                         MySQL will round when storing values with more that 2 decimal places */
            $table->float('hourly_rate');
            $table->enum('currency', config('exchangerate.allowed_currencies'));
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
        Schema::dropIfExists('users');
    }
}
