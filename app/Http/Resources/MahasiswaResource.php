<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class MahasiswaResource extends JsonResource
{

	public function toArray($request){
		return [
			'nama'     => $this->nama,
			'npm'      => $this->npm,
			'kelas'    => $this->kelas,
			'jurusan'  => $this->jurusan,
			'angkatan' => $this->angkatan,
			'phone'    => $this->details->phone,
			'alamat'   => $this->details->alamat,
			'foto'     => $this->details->foto
		];
		// return parent::toArray($request);
	}

	public function with($request)
	{
		return [
			// 'created' => $this->created_at->diffForHumans(),
			'status'  => true,
			'message' => 'Detail Mahasiswa'
		];
	}

}