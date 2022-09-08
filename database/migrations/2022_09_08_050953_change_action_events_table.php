<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('action_events', function (Blueprint $table) {
            $table->string("actionable_type")->change();
            $table->uuid("actionable_id")->change();
//            $table->index(['actionable_type', "actionable_id"]);

            $table->string("target_type")->change();
            $table->uuid("target_id")->change();
//            $table->index(['target_type', "target_id"]);

            $table->uuid('model_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
