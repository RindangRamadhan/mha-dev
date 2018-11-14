<?php

use Illuminate\Database\Seeder;
use App\Iklan;

class IklanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Create Iklan
        $owner = new Iklan(); 
        $owner->name = "Facebook";
        $owner->save();

        // Create Iklan
        $owner = new Iklan(); 
        $owner->name = "Adsense";
        $owner->save();
    }
}
