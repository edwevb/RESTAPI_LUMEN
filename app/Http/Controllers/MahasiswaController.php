<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use App\Models\DetailMahasiswa;

class MahasiswaController extends Controller
{
    public function index()
    {
        try {
            $mahasiswas = MahasiswaResource::collection(Mahasiswa::get());
            if ($mahasiswas->isEmpty()) throw new \Exception('No data');
            return response()->json([
                "data" => $mahasiswas,
                'success' => true,
                'message' =>'Data Mahasiswa'
            ], 200);

        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],200);
        }
    }
    
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:32',
            'npm' => 'required|unique:mahasiswas|size:8',
            'kelas' => 'required|size:5',
            'jurusan' => 'required|max:64',
            'angkatan' => 'required|size:4',
            'phone' => 'required|max:16'
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }else{
            try {
                $mahasiswas = Mahasiswa::create($request->all());
                $mahasiswas->details()->create($request->all());

                if (!$mahasiswas) throw new \Exception('Oops! something error, please try again!');
                return response()->json([
                    'success' => true,
                    'message' => 'Data has been created!'
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }
        }
    }

    public function show($npm)
    {
        $mahasiswas = Mahasiswa::where('npm', $npm)->first();
        if(empty($mahasiswas)){
            return response()->json([
                'success' => false,
                'message' => "No data"
            ], 206);
        }
        $data = new MahasiswaResource($mahasiswas);
        return response()->json([
            'data' => $data,
            'success' => false,
            'message' => "No data"
        ]);
        
    }

    public function update(Request $request, $npm)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:32',
            'npm' => 'required|size:8|exists:mahasiswas,npm',
            'kelas' => 'required|size:5',
            'jurusan' => 'required|max:64',
            'angkatan' => 'required|size:4',
            'phone' => 'required|max:16'
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }else{
            try {
                $mahasiswas = Mahasiswa::where('npm', $npm)->first();
                $mahasiswas->update([
                 'nama' => $request->nama,
                 'npm' => $request->npm,
                 'kelas' => $request->kelas,
                 'jurusan' => $request->jurusan,
                 'angkatan' => $request->angkatan
             ]);

                $details = $mahasiswas->details();
                $details->update([
                    'phone' => $request->phone,
                    'alamat' => $request->alamat,
                    'foto' => $request->foto,
                    'mahasiswa_id' => $mahasiswas->id
                ]);

                if (!$mahasiswas && !details) throw new \Exception('Oops! something error, please try again!');

                return response()->json([
                    'success' => true,
                    'message' => 'Data has been updated!'
                ], 200);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }
        }
    }

    public function destroy($npm)
    {
        try {
            Mahasiswa::where('npm', $npm)->first()->delete();
            return response()->json([
                'success' => true,
                'message' => "Data successfully deleted!"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
