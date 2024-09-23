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
        $csv = Reader::createFromPath(public_path('old_data/works/works.csv'), 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $item) {
            $data =  explode(' - ', $item['Задача']);

            if (count($data) > 1)
                DB::table("day_works")->insert([
                    'name' => $data[1],
                    'client' => $data[0],
                ]);
        }
    }
}
