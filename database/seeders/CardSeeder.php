<?php

namespace Database\Seeders;

use App\Models\Card;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Card::create([
            'title' => 'Tata Kelola Aset',
            'description' => 'Sistem manajemen dan tata kelola aset perusahaan',
            'icon' => 'fas fa-boxes',
            'url' => 'https://assets.atmi.ac.id',
            'order' => 1,
            'category' => 'internal',
        ]);

        Card::create([
            'title' => 'Perboikan Sarana/Tiket',
            'description' => 'Platform pelaporan dan permohonan perbaikan sarana',
            'icon' => 'fas fa-tools',
            'url' => 'https://maintenance.atmi.ac.id',
            'order' => 2,
            'category' => 'internal',
        ]);

        Card::create([
            'title' => 'SIPENA',
            'description' => 'Sistem Informasi Perencanaan Nasional',
            'icon' => 'fas fa-chart-bar',
            'url' => 'https://sipena.atmi.ac.id',
            'order' => 3,
            'category' => 'external',
        ]);

        Card::create([
            'title' => 'Sistem Informasi Akademik ATM',
            'description' => 'Portal akademik untuk manajemen nilai dan registrasi',
            'icon' => 'fas fa-graduation-cap',
            'url' => 'https://sia.atmi.ac.id',
            'order' => 4,
            'category' => 'internal',
        ]);

        Card::create([
            'title' => 'Sistem Penerimaan Mahasiswa Baru ATM',
            'description' => 'Portal pendaftaran dan penerimaan mahasiswa baru',
            'icon' => 'fas fa-user-plus',
            'url' => 'https://pmb.atmi.ac.id',
            'order' => 5,
            'category' => 'external',
        ]);

        Card::create([
            'title' => 'Aplikasi Surat Tugas ATMI',
            'description' => 'Sistem pembuatan dan manajemen surat tugas',
            'icon' => 'fas fa-file-alt',
            'url' => 'https://tugasatmi.ac.id',
            'order' => 6,
            'category' => 'internal',
        ]);

        Card::create([
            'title' => 'Perpustakaan ATMI',
            'description' => 'Portal perpustakaan digital dan manajemen koleksi',
            'icon' => 'fas fa-book',
            'url' => 'https://perpus.atmi.ac.id',
            'order' => 7,
            'category' => 'internal',
        ]);

        Card::create([
            'title' => 'Aplikasi Surat Kepuusan Menggajar',
            'description' => 'Sistem penerbitan surat keputusan mengajar',
            'icon' => 'fas fa-scroll',
            'url' => 'https://skm.atmi.ac.id',
            'order' => 8,
            'category' => 'internal',
        ]);

        Card::create([
            'title' => 'Aplikasi Surat Bebas Tanggungan ATMI',
            'description' => 'Platform pembuatan surat bebas tanggungan',
            'icon' => 'fas fa-certificate',
            'url' => 'https://bebastaggunan.atmi.ac.id',
            'order' => 9,
            'category' => 'external',
        ]);

        Card::create([
            'title' => 'ATMI Press',
            'description' => 'Portal penerbitan dan publikasi karya ilmiah',
            'icon' => 'fas fa-newspaper',
            'url' => 'https://press.atmi.ac.id',
            'order' => 10,
            'category' => 'external',
        ]);
    }
}

