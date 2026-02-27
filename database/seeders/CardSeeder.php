<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Institution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get institutions
        $yayas = Institution::where('name', 'Yayasan Karya Bakti Surakarta')->first();
        $politeknik = Institution::where('name', 'Politeknik ATMI')->first();
        $ptAtmi = Institution::where('name', 'PT ATMI Solo')->first();
        $ptIGI = Institution::where('name', 'PT IGI')->first();
        $ptADE = Institution::where('name', 'PT ADE')->first();
        $ptBizDec = Institution::where('name', 'PT BIZDEC')->first();

        // Cards for Politeknik ATMI
        Card::firstOrCreate(['title' => 'Sistem Informasi Akademik ATMI'], [
            'description' => 'Portal akademik untuk manajemen nilai dan registrasi',
            'icon' => 'fas fa-graduation-cap',
            'url' => 'https://sia.atmi.ac.id',
            'order' => 1,
            'category' => 'internal',
            'institution_id' => $politeknik?->id,
        ]);

        Card::firstOrCreate(['title' => 'Sistem Penerimaan Mahasiswa Baru'], [
            'description' => 'Portal pendaftaran dan penerimaan mahasiswa baru',
            'icon' => 'fas fa-user-plus',
            'url' => 'https://pmb.atmi.ac.id',
            'order' => 2,
            'category' => 'external',
            'institution_id' => $politeknik?->id,
        ]);

        Card::firstOrCreate(['title' => 'Perpustakaan Digital'], [
            'description' => 'Portal perpustakaan digital dan manajemen koleksi',
            'icon' => 'fas fa-book',
            'url' => 'https://perpus.atmi.ac.id',
            'order' => 3,
            'category' => 'internal',
            'institution_id' => $politeknik?->id,
        ]);

        // Cards for PT ATMI Solo
        Card::firstOrCreate(['title' => 'Sistem Portal ATMI Solo'], [
            'description' => 'Portal utama PT ATMI Solo',
            'icon' => 'fas fa-globe',
            'url' => 'https://pt-atmi.ac.id',
            'order' => 1,
            'category' => 'external',
            'institution_id' => $ptAtmi?->id,
        ]);

        Card::firstOrCreate(['title' => 'Sistem Informasi Karyawan'], [
            'description' => 'Platform manajemen data dan informasi karyawan',
            'icon' => 'fas fa-users',
            'url' => 'https://hris.pt-atmi.ac.id',
            'order' => 2,
            'category' => 'internal',
            'institution_id' => $ptAtmi?->id,
        ]);

        Card::firstOrCreate(['title' => 'Tata Kelola Aset'], [
            'description' => 'Sistem manajemen dan tata kelola aset perusahaan',
            'icon' => 'fas fa-boxes',
            'url' => 'https://assets.pt-atmi.ac.id',
            'order' => 3,
            'category' => 'internal',
            'institution_id' => $ptAtmi?->id,
        ]);

        // Cards for PT IGI
        Card::firstOrCreate(['title' => 'Portal PT IGI'], [
            'description' => 'Website resmi PT IGI',
            'icon' => 'fas fa-globe',
            'url' => 'https://pt-igi.ac.id',
            'order' => 1,
            'category' => 'external',
            'institution_id' => $ptIGI?->id,
        ]);

        Card::firstOrCreate(['title' => 'Sistem Akademik IGI'], [
            'description' => 'Platform akademik PT IGI',
            'icon' => 'fas fa-graduation-cap',
            'url' => 'https://akademik.pt-igi.ac.id',
            'order' => 2,
            'category' => 'internal',
            'institution_id' => $ptIGI?->id,
        ]);

        // Cards for PT ADE
        Card::firstOrCreate(['title' => 'Portal PT ADE'], [
            'description' => 'Website resmi PT ADE',
            'icon' => 'fas fa-globe',
            'url' => 'https://pt-ade.ac.id',
            'order' => 1,
            'category' => 'external',
            'institution_id' => $ptADE?->id,
        ]);

        Card::firstOrCreate(['title' => 'LMS PT ADE'], [
            'description' => 'Learning Management System PT ADE',
            'icon' => 'fas fa-chalkboard',
            'url' => 'https://lms.pt-ade.ac.id',
            'order' => 2,
            'category' => 'internal',
            'institution_id' => $ptADE?->id,
        ]);

        // Cards for PT BIZDEC
        Card::firstOrCreate(['title' => 'Portal PT BIZDEC'], [
            'description' => 'Website resmi PT BIZDEC',
            'icon' => 'fas fa-globe',
            'url' => 'https://pt-bizdec.ac.id',
            'order' => 1,
            'category' => 'external',
            'institution_id' => $ptBizDec?->id,
        ]);

        Card::firstOrCreate(['title' => 'Sistem ERP BIZDEC'], [
            'description' => 'Enterprise Resource Planning System',
            'icon' => 'fas fa-server',
            'url' => 'https://erp.pt-bizdec.ac.id',
            'order' => 2,
            'category' => 'internal',
            'institution_id' => $ptBizDec?->id,
        ]);

        // Cards for Yayasan
        Card::firstOrCreate(['title' => 'Portal Yayasan'], [
            'description' => 'Website resmi Yayasan Karya Bakti Surakarta',
            'icon' => 'fas fa-globe',
            'url' => 'https://yayasan-karya-bakti.ac.id',
            'order' => 1,
            'category' => 'external',
            'institution_id' => $yayas?->id,
        ]);

        // General cards without institution
        Card::firstOrCreate(['title' => 'SIPENA'], [
            'description' => 'Sistem Informasi Perencanaan Nasional',
            'icon' => 'fas fa-chart-bar',
            'url' => 'https://sipena.atmi.ac.id',
            'order' => 1,
            'category' => 'external',
            'institution_id' => null,
        ]);

        Card::firstOrCreate(['title' => 'Aplikasi Surat Tugas'], [
            'description' => 'Sistem pembuatan dan manajemen surat tugas',
            'icon' => 'fas fa-file-alt',
            'url' => 'https://tugasatmi.ac.id',
            'order' => 2,
            'category' => 'internal',
            'institution_id' => null,
        ]);

        Card::firstOrCreate(['title' => 'ATMI Press'], [
            'description' => 'Portal penerbitan dan publikasi karya ilmiah',
            'icon' => 'fas fa-newspaper',
            'url' => 'https://press.atmi.ac.id',
            'order' => 3,
            'category' => 'external',
            'institution_id' => null,
        ]);
    }
}

