<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Halpdesk\LaravelMinimumPackage\Contracts\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Instantiate to get table info
        $user = app(User::class);

        Schema::create($user->getTable(), function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $user = app(User::class);
        Schema::dropIfExists($user->getTable());
    }
}
