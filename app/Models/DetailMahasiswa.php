<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class DetailMahasiswa extends Model {

	protected $table = 'detail_mahasiswas';
	protected $fillable = [
		'fakultas', 'phone', 'alamat','foto','mahasiswa_id'
	];

	public function mahasiswa()
	{
		return $this->belongsTo('App\Models\Mahasiswa');
	}
}