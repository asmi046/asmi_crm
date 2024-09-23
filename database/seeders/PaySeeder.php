<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use League\Csv\Reader;

use DB;

class PaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csv = Reader::createFromPath(public_path('old_data/smets/smets.csv'), 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $item) {

            if (empty($item['Проект'])) continue;

            $date_array = explode('/', $item['Дата']);

            DB::table("pays")->insert([
                'name' => $item['Работа'],
                'client' => $item['Проект'],
                // 'do_time' => date("Y-m-d", strtotime($item['Дата'])),
                'do_time' => $date_array[2]."-".$date_array[1]."-".$date_array[0],
                'price' => $item["Цена"]
            ]);
        }
    }
}
