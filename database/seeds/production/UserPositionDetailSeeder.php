<?php

namespace Seed\Production;

use Illuminate\Database\Seeder;
use App\UserPositionDetail;

class UserPositionDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserPositionDetail::create([
            'position_detail' => 'Seksi Kesehatan Keluarga, Ibu, Anak & Gizi'
        ]);

        UserPositionDetail::create([
            'position_detail' => 'Seksi Kesehatan Lingkungan, Kes. Kerja & Kesehatan Olah Raga'
        ]);

        UserPositionDetail::create([
            'position_detail' => 'Seksi Promosi Dan Pemberdayaan Masyarakat'
        ]);

        UserPositionDetail::create([
            'position_detail' => 'Seksi Surveilans Dan Imunisasi'
        ]);
        
        UserPositionDetail::create([
            'position_detail' => 'Seksi Pencegahan Dan Pengendalian Penyakit Menular'
            ]);
            
        UserPositionDetail::create([
            'position_detail' => 'Seksi Pencegahan & Pengendalian Penyakit Tidak Menular & Kes. Jiwa'
        ]);
    
        UserPositionDetail::create([
            'position_detail' => 'Seksi Pelayanan Kesehatan'
        ]);
        
        UserPositionDetail::create([
            'position_detail' => 'Seksi Kefarmasian Dan Alat Kesehatan'
        ]);
        
        UserPositionDetail::create([
            'position_detail' => 'Seksi Sumber Daya Kesehatan'
        ]);
    }
}
