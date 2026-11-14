<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Article;
use App\Models\Gallery;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin',
            'password' => bcrypt('password'),
        ]);

        $products = [
            [
                'Internet Broadband Rumahan',
                350000,
                'Koneksi internet stabil untuk rumah, mulai dari kebutuhan harian sampai hiburan streaming.',
                ['Kecepatan hingga 100 Mbps', 'Wi-Fi dual-band', 'Bantuan teknis via WhatsApp'],
                '/ bulan',
            ],
            [
                'Internet Broadband Bisnis',
                1200000,
                'Koneksi internet kantor dan bisnis dengan prioritas bandwidth dan dukungan lebih cepat.',
                ['Kecepatan hingga 300 Mbps', 'Prioritas bandwidth', 'IP statis opsional', 'Laporan pemakaian bulanan'],
                '/ bulan',
            ],
            [
                'Instalasi Jaringan LAN & Wi-Fi',
                1500000,
                'Pemasangan jaringan lengkap: kabel, router, switch, access point, hingga konfigurasi siap pakai.',
                ['Survey lokasi gratis', 'Kabel dan perangkat bermerek', 'Konfigurasi LAN dan Wi-Fi', 'Garansi instalasi 30 hari'],
                '/ proyek',
            ],
            [
                'Maintenance Jaringan',
                750000,
                'Perawatan berkala jaringan Anda: pemeriksaan perangkat, penanganan gangguan, dan optimasi koneksi.',
                ['Kunjungan berkala', 'Pembersihan dan update firmware', 'Penanganan gangguan prioritas', 'Laporan kondisi jaringan'],
                '/ bulan',
            ],
            [
                'Paket Hotspot & Voucher',
                2500000,
                'Solusi hotspot berbayar untuk kafe, kos, dan penginapan dengan manajemen voucher otomatis.',
                ['Portal login voucher', 'Manajemen paket otomatis', 'Monitoring pengguna', 'Instalasi dan konfigurasi'],
                '/ proyek',
            ],
        ];

        foreach ($products as [$name, $price, $desc, $features, $unit]) {
            Product::updateOrCreate(['name' => $name], [
                'price' => $price,
                'unit' => $unit,
                'description' => $desc,
                'features' => $features,
            ]);
        }

        Product::whereIn('name', [
            'Desain Logo',
            'Paket Konten Sosmed',
            'Brand Identity Lengkap',
            'Desain Banner & Spanduk',
        ])->delete();

        $articles = [
            [
                'Tips Memilih Paket Internet untuk Rumah',
                'Mulai dari jumlah pengguna, jenis aktivitas, dan luas area. Untuk rumah dengan banyak perangkat dan streaming, pilih paket dengan kecepatan minimal 50 Mbps agar tetap nyaman saat jam sibuk.',
            ],
            [
                'Kapan Perlu Maintenance Jaringan?',
                'Lakukan pemeriksaan rutin setiap 3 sampai 6 bulan. Tanda jaringan perlu maintenance: koneksi lambat di jam tertentu, perangkat sering reconnect, atau Wi-Fi yang tidak menjangkau seluruh area.',
            ],
            [
                'Cara Memperkuat Sinyal Wi-Fi di Rumah',
                'Letakkan router di pusat rumah dan jauh dari perangkat elektronik lain. Gunakan access point tambahan untuk area jauh, dan pastikan firmware router selalu diperbarui.',
            ],
            [
                'LAN atau Wi-Fi: Mana yang Lebih Cocok?',
                'LAN kabel lebih stabil dan cocok untuk perangkat tetap seperti PC kasir atau server. Wi-Fi lebih fleksibel untuk perangkat bergerak. Kombinasi keduanya biasanya memberi hasil terbaik.',
            ],
        ];

        foreach ($articles as [$title, $body]) {
            Article::firstOrCreate(['title' => $title], ['body' => $body]);
        }

        Article::whereIn('title', [
            '5 Kesalahan Umum Saat Membuat Logo',
            'Cara Memilih Warna Brand yang Tepat',
            'Brief Desain: Apa Saja yang Perlu Disiapkan?',
            'Kenapa Konsistensi Visual Itu Penting',
        ])->delete();

        $galleries = [
            ['Instalasi Jaringan Kantor 3 Lantai', 'Pemasangan LAN dan 6 titik access point.'],
            ['Hotspot Voucher Kafe', 'Portal login voucher dengan manajemen paket otomatis.'],
            ['Maintenance Rutin Pabrik', 'Pemeriksaan switch, kabel, dan optimasi jaringan.'],
        ];

        foreach ($galleries as [$title, $desc]) {
            Gallery::firstOrCreate(['title' => $title], ['description' => $desc]);
        }

        Gallery::whereIn('title', [
            'Logo Kopi Senja',
            'Feed Instagram Toko Bunga',
            'Brand Identity Studio Yoga',
        ])->delete();
    }
}
