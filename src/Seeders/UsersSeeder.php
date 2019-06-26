<?php

namespace Halpdesk\LaravelMinimumPackage\Seeders;

use Illuminate\Database\Seeder;
use Halpdesk\LaravelMinimumPackage\Contracts\User as UserContract;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Resolve payment class
        $user = app(UserContract::class);

        // Create user
        $user::create([
            'name' => 'Test User'
        ]);
    }
}
