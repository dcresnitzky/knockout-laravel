<?php

use Illuminate\Database\Seeder;

class ProdutosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('produtos')->insert([
            'nome' => 'Parafuso',
            'preco' => '0.1',
            'estoque' => 0,
        ]);
        DB::table('produtos')->insert([
            'nome' => 'Porca',
            'preco' => '0.05',
            'estoque' => 200,
        ]);
        DB::table('produtos')->insert([
            'nome' => 'Prego',
            'preco' => '0.2',
            'estoque' => 1000,
        ]);
        DB::table('produtos')->insert([
            'nome' => 'Dobradiças',
            'preco' => '1.50',
            'estoque' => 10,
        ]);
    }
}
