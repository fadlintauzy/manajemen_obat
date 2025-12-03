<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Obat;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. User 'admin' is already created in the migration (0001_01_01_000000_create_users_table.php)
        // So we skip creating it here to avoid duplicate entry error.
        // Note: The migration now creates admin with just username and password.
        $suppliers = [
            ['nama_supplier' => 'PT. Kimia Farma'],
            ['nama_supplier' => 'PT. Kalbe Farma'],
            ['nama_supplier' => 'PT. Dexa Medica'],
        ];
        
        foreach ($suppliers as $s) {
            Supplier::create($s);
        }

        // 3. Create Obats
        $obats = [
            [
                'nama_obat' => 'Cetirizine',
                'dosis' => '10mg',
                'satuan' => 'Tablet',
                'category' => 'Antihistamin'
            ],
            [
                'nama_obat' => 'Paracetamol',
                'dosis' => '500mg',
                'satuan' => 'Tablet',
                'category' => 'Analgesik'
            ],
            [
                'nama_obat' => 'Amoxicillin',
                'dosis' => '500mg',
                'satuan' => 'Kapsul',
                'category' => 'Antibiotik'
            ],
            [
                'nama_obat' => 'Ibuprofen',
                'dosis' => '400mg',
                'satuan' => 'Tablet',
                'category' => 'Analgesik'
            ],
            [
                'nama_obat' => 'Vitamin C',
                'dosis' => '500mg',
                'satuan' => 'Tablet',
                'category' => 'Vitamin'
            ]
        ];

        foreach ($obats as $o) {
            Obat::create($o);
        }

        // 4. Create Batches (Dummy Data for Dashboard)
        
        // Expired Batch
        Batch::create([
            'id_obat' => 1, // Cetirizine
            'id_supplier' => 1,
            'no_batches' => 'CTZ-2024-001',
            'stok' => 1800,
            'tgl_penerimaan' => Carbon::now()->subYear(),
            'tgl_kadaluarsa' => Carbon::now()->subDay(), // Expired yesterday
            'lokasi_penyimpanan' => 'Rak F-03'
        ]);

        // Warning Batch (Expiring soon)
        Batch::create([
            'id_obat' => 2, // Paracetamol
            'id_supplier' => 2,
            'no_batches' => 'PCT-2024-001',
            'stok' => 5000,
            'tgl_penerimaan' => Carbon::now()->subMonths(6),
            'tgl_kadaluarsa' => Carbon::now()->addDays(15), // Expiring in 15 days
            'lokasi_penyimpanan' => 'Rak A-01'
        ]);

        // Warning Batch 2
        Batch::create([
            'id_obat' => 3, // Amoxicillin
            'id_supplier' => 3,
            'no_batches' => 'AMX-2024-001',
            'stok' => 3000,
            'tgl_penerimaan' => Carbon::now()->subMonths(3),
            'tgl_kadaluarsa' => Carbon::now()->addDays(45), // Expiring in 45 days
            'lokasi_penyimpanan' => 'Rak B-03'
        ]);

        // Safe Batch
        Batch::create([
            'id_obat' => 4, // Ibuprofen
            'id_supplier' => 1,
            'no_batches' => 'IBU-2024-001',
            'stok' => 6000,
            'tgl_penerimaan' => Carbon::now()->subMonths(2),
            'tgl_kadaluarsa' => Carbon::now()->addDays(100), // Safe
            'lokasi_penyimpanan' => 'Rak A-05'
        ]);

        // Low Stock Batch
        Batch::create([
            'id_obat' => 5, // Vitamin C
            'id_supplier' => 2,
            'no_batches' => 'VIT-2024-001',
            'stok' => 50, // Low stock
            'tgl_penerimaan' => Carbon::now()->subMonths(1),
            'tgl_kadaluarsa' => Carbon::now()->addYear(),
            'lokasi_penyimpanan' => 'Rak C-01'
        ]);
        // 5. Create Activities (Dummy Data)
        $batches = Batch::all();
        
        foreach ($batches as $batch) {
            // Initial Stock (Masuk)
            \App\Models\Activity::create([
                'id_batch' => $batch->id_batch,
                'jenis_aktivitas' => 'masuk',
                'jumlah' => $batch->stok + rand(100, 500), // Assuming initial was higher
                'sisa_stok' => $batch->stok + rand(100, 500),
                'created_at' => $batch->tgl_penerimaan,
            ]);

            // Random transactions
            if (rand(0, 1)) {
                \App\Models\Activity::create([
                    'id_batch' => $batch->id_batch,
                    'jenis_aktivitas' => 'keluar',
                    'jumlah' => rand(10, 50),
                    'sisa_stok' => $batch->stok,
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }

        // Specific recent activities for dashboard demo
        $recentActivities = [
            [
                'id_batch' => 1, // Cetirizine
                'jenis_aktivitas' => 'penyesuaian',
                'jumlah' => 50,
                'sisa_stok' => 1800,
                'created_at' => now()->subDays(1),
            ],
            [
                'id_batch' => 2, // Paracetamol
                'jenis_aktivitas' => 'keluar',
                'jumlah' => 5000,
                'sisa_stok' => 5000,
                'created_at' => now()->subDays(3),
            ],
            [
                'id_batch' => 3, // Amoxicillin
                'jenis_aktivitas' => 'keluar',
                'jumlah' => 2000,
                'sisa_stok' => 3000,
                'created_at' => now()->subDays(5),
            ],
            [
                'id_batch' => 2, // Paracetamol
                'jenis_aktivitas' => 'masuk',
                'jumlah' => 10000,
                'sisa_stok' => 10000,
                'created_at' => now()->subDays(10),
            ]
        ];

        foreach ($recentActivities as $act) {
            \App\Models\Activity::create($act);
        }
    }
}
