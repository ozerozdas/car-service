<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Services;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'name' => 'Araç Bakımı' ],
            [ 'name' => 'Yağ Değişimi' ],
            [ 'name' => 'Akü' ],
            [ 'name' => 'Fren' ],
            [ 'name' => 'Kontrol' ],
            [ 'name' => 'Triger Kayışı' ],
            [ 'name' => 'Yol Görüş Elemanları' ],
            [ 'name' => 'Klima' ],
            [ 'name' => 'Süspansiyon' ],
            [ 'name' => 'Lastikler' ],
            [ 'name' => 'Egzoz' ],
            [ 'name' => 'Mekanik Onarımlar' ],
        ];
        Services::truncate();
        Services::insert($data);
    }
}
