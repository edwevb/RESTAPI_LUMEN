<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Mahasiswa extends Model {

	protected $table = 'mahasiswas';
	protected $fillable = [
		'nama', 'npm', 'kelas', 'jurusan', 'angkatan', 'user_id'
	];
	protected $with = ['details'];

	public function details()
	{
		return $this->hasOne('App\Models\DetailMahasiswa');
	}


	public function getPhoneAttribute(){
		return $this->details->phone;
	}

	public function getMahasiswa(){
		// $mahasiswas = Mahasiswa::with(['details' => function($query) {
		// 	return $query->select(['mahasiswa_id','phone','alamat','foto']);
		// }])->get();
		// $mahasiswas = Mahasiswa::without('details')->get();
		// if ($mahasiswas->isEmpty()) throw new \Exception('No data yet!');
		// return $mahasiswas;
	}

}