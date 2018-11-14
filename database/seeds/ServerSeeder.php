<?php

use Illuminate\Database\Seeder;
use App\Server;

class ServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Server
        $owner = new Server(); 
        $owner->name = "Indonesia";
        $owner->save();

        // Create Server
        $owner = new Server(); 
        $owner->name = "Malaysia";
        $owner->save();
    }
}
