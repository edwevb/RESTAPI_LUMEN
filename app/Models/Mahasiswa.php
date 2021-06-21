<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Mahasiswa extends Model{

	protected $table = 'mahasiswas';
	protected $fillable = [
		'nama', 'npm', 'kelas'
	];

	public function findMahasiswa(){
		$mahasiswas = Mahasiswa::get();
		if ($mahasiswas->isEmpty()) throw new \Exception('No data found');
		return $mahasiswas;
	}
}