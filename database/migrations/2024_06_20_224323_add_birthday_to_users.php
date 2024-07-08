<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('person', function (Blueprint $table) {
            $table->dateTime('birthday')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('person', function (Blueprint $table) {
            //
        });
    }
};
