<?php

namespace Database\Seeders;

use DB;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patch = public_path('old_data/sites');
        $cdir = scandir($patch);
        foreach ($cdir as $key => $value)
        {
            if (!in_array($value,array(".","..")))
            {
                echo $value."\n\r";
                $name = mb_substr($value, 0, mb_strripos($value," ", 0));
                $file_info = new \SplFileInfo($value);

                if (in_array($name, ['Key Password', 'Untitled', 'mkc2018', 'Логин', 'Пароль'])) continue;
                if ($file_info->getExtension() !== "md") continue;

                DB::table("sites")->insert(
                    [
                        'name' => $name,
                        'description' => Str::markdown(file_get_contents($patch.'/'.$value))
                    ]
                );
            }
        }
    }
}
