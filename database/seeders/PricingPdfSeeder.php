<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricingPdfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pricing_pdfs')->insert([
            [
                'pdf_url_a' => 'https://olfat.ams3.cdn.digitaloceanspaces.com/uploads/pricing/documents/1727796606_66fc157e9548e_shipping.pdf',
                'pdf_url_b' => null,
            ],
            [
                'pdf_url_a' => 'https://olfat.ams3.cdn.digitaloceanspaces.com/uploads/pricing/documents/1729409021_6714affd2e819_shipping.pdf',
                'pdf_url_b' => 'uploads/pricing/documents/1729409033_6714b0095178d_shipping.pdf',
            ],
            [
                'pdf_url_a' => 'https://olfat.ams3.cdn.digitaloceanspaces.com/uploads/pricing/documents/1730377699_672377e39790a_shipping.pdf',
                'pdf_url_b' => 'uploads/pricing/documents/1730377710_672377ee07301_shipping.pdf',
            ],
            [
                'pdf_url_a' => 'https://olfat.ams3.cdn.digitaloceanspaces.com/uploads/pricing/documents/1730381008_672384d04b2b0_shipping.pdf',
                'pdf_url_b' => 'uploads/pricing/documents/1730381019_672384db1396f_shipping.pdf',
            ],
            [
                'pdf_url_a' => 'https://olfat.ams3.cdn.digitaloceanspaces.com/uploads/pricing/documents/1730381150_6723855e386ea_shipping.pdf',
                'pdf_url_b' => 'uploads/pricing/documents/1730381161_672385691d766_shipping.pdf',
            ],
            [
                'pdf_url_a' => 'https://olfat.ams3.cdn.digitaloceanspaces.com/uploads/pricing/documents/1730381491_672386b34a104_shipping.pdf',
                'pdf_url_b' => 'uploads/pricing/documents/1730381502_672386bee0e0a_shipping.pdf',
            ],
            [
                'pdf_url_a' => 'https://olfat.ams3.cdn.digitaloceanspaces.com/uploads/pricing/documents/1730382994_67238c922b3c5_shipping.pdf',
                'pdf_url_b' => 'uploads/pricing/documents/1730383005_67238c9d33019_shipping.pdf',
            ],
            [
                'pdf_url_a' => 'https://olfat.ams3.cdn.digitaloceanspaces.com/uploads/pricing/documents/1731249459_6730c533571c1_shipping.pdf',
                'pdf_url_b' => 'uploads/pricing/documents/1731249469_6730c53dae5d9_shipping.pdf',
            ],
            [
                'pdf_url_a' => 'https://olfat.ams3.cdn.digitaloceanspaces.com/uploads/pricing/documents/1734429188_67614a04a1497_shipping.pdf',
                'pdf_url_b' => 'uploads/pricing/documents/1734429199_67614a0f3f5c8_shipping.pdf',
            ],
        ]);
    }
}
