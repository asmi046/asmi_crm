<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use League\Csv\Reader;

use DB;

class DayWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = Reader::createFromPath(public_path('old_data/smets/smets.csv'), 'r');
        $records = $csv->getRecords();
        foreach ($records as $item) {
          print_r($item);
        }
    }
}
