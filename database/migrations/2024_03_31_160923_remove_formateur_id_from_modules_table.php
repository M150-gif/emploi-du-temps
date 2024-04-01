<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn('formateur_id');
        });
    }

    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->foreignId('formateur_id')->constrained()->onDelete('cascade');
        });
    }
};
