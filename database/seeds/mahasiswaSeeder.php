<?php

use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{

	public function run()
	{
		\DB::table('mahasiswas')->insert([
			'nama' => 'Edward Evbert',
			'npm'  => '17117369',
			'kelas'=> '4KA20',
			'created_at' => now()
		]);
	}
}
