<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class SetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userID = DB::table("setings")->insertGetId(
            [
                'name' => "selectedClient",
                'type' => "String",
                'value' => "Мир туризма"
            ]
        );
    }
}
