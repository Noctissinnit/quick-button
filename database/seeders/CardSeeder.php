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
        $ykbs = Institution::where('name', 'Yayasan Karya Bakti Surakarta')->first();
        $poltek = Institution::where('name', 'Politeknik ATMI')->first();
        $ptAtmiSolo = Institution::where('name', 'PT ATMI Solo')->first();

        // Cards for YKBS
        Card::truncate();
        
        $order = 1;
        $ykbsLinks = [
            'https://yayasankaryabakti.org/',
            'https://fa.yayasankaryabakti.org/',
            'https://ticket.yayasankaryabakti.org/',
            'https://bookingroom.yayasankaryabakti.org/',
            'https://invcom.atmicorp.com/',
        ];

        foreach ($ykbsLinks as $url) {
            Card::create([
                'title' => basename(parse_url($url, PHP_URL_PATH), '/') ?: 'Link',
                'description' => 'Link YKBS',
                'icon' => 'fas fa-link',
                'url' => $url,
                'order' => $order++,
                'category' => 'external',
                'institution_id' => $ykbs?->id,
            ]);
        }

        // Cards for POLTEK
        $order = 1;
        $poltekLinks = [
            'https://atmi.ac.id/',
            'https://atmi.ac.id/monik/',
            'https://atmi.ac.id/news',
            'https://lsp.atmi.ac.id/',
            'https://e-learning.atmi.ac.id/',
            'http://jobfair.atmi.ac.id/',
            'https://careersworkshop.atmi.ac.id/',
            'https://wisuda.atmi.ac.id/',
            'https://studentaffair.atmi.ac.id/',
            'https://spmi.atmi.ac.id/',
            'https://finance.atmi.ac.id/',
            'http://pm.atmi.ac.id/',
            'https://rtm.atmi.ac.id/',
            'https://tmi.atmi.ac.id/',
            'https://tmk.atmi.ac.id/',
            'https://tpm.atmi.ac.id/',
            'https://trmk.atmi.ac.id/',
            'https://imdec.atmi.ac.id/',
            'https://publikasi.atmi.ac.id/',
            'https://repository.atmi.ac.id/',
            'https://journal.atmi.ac.id/',
            'https://sapenagm.atmi.ac.id/',
            'https://sipenarpm.atmi.ac.id/',
            'https://sipenartm.atmi.ac.id/',
            'https://manika.atmi.ac.id/',
            'https://suratdigital.atmi.ac.id/',
            'https://surattugasmahasiswa.atmi.ac.id/',
            'https://atmipress.atmi.ac.id/',
            'https://skmengajar.atmi.ac.id/',
            'https://sbt.atmi.ac.id/',
            'https://ujianspmb.atmi.ac.id/',
            'https://lppm.atmi.ac.id/',
            'https://penelitian.atmi.ac.id/',
            'http://penghitungjam.atmi.online/',
            'http://presensi.atmi.online/',
        ];

        foreach ($poltekLinks as $url) {
            Card::create([
                'title' => basename(parse_url($url, PHP_URL_PATH), '/') ?: 'Link',
                'description' => 'Link Politeknik ATMI',
                'icon' => 'fas fa-link',
                'url' => $url,
                'order' => $order++,
                'category' => 'external',
                'institution_id' => $poltek?->id,
            ]);
        }

        // Cards for PT ATMI SOLO
        $order = 1;
        $ptAtmiSoloLinks = [
            'https://finmon.atmi.co.id/',
            'https://wp.atmi.co.id/',
            'https://stockbar.atmi.co.id/',
            'https://marketing.atmi.co.id/',
            'https://surattugas.atmicorp.com/',
            'https://siinas.atmicorp.com/',
        ];

        foreach ($ptAtmiSoloLinks as $url) {
            Card::create([
                'title' => basename(parse_url($url, PHP_URL_PATH), '/') ?: 'Link',
                'description' => 'Link PT ATMI Solo',
                'icon' => 'fas fa-link',
                'url' => $url,
                'order' => $order++,
                'category' => 'external',
                'institution_id' => $ptAtmiSolo?->id,
            ]);
        }
    }
}

