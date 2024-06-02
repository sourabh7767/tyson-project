<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnsToJobFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job_forms', function (Blueprint $table) {
            $table->tinyInteger('is_lead')->default(0)->comment('0 => NO, 1 => YES');
            $table->double('admin_comission_per')->nullable();
            $table->double('admin_comission_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job_forms', function (Blueprint $table) {
            $table->dropColumn('is_lead');
            $table->dropColumn('admin_comission_per');
            $table->dropColumn('admin_comission_amount');
        });
    }
}
