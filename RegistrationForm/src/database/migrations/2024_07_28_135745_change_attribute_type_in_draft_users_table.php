<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAttributeTypeInDraftUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('draftuser', function (Blueprint $table) {
            // Example: Change `image_url` column type from string to text
            $table->integer('current_status')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('draftuser', function (Blueprint $table) {
            // Reverse the column type change
            $table->string('current_status')->change();
        });
    }
}
