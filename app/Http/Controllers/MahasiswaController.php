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
            'npm' => 'required|size:8',
            'kelas' => 'required|size:5',
            'jurusan' => 'required|max:64',
            'angkatan' => 'required|size:4'
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }else{
            try {
                $mahasiswas = Mahasiswa::create($request->only(
                    'nama', 'npm', 'kelas', 'jurusan','angkatan'
                ));
                $mahasiswas->details()->create($request->only(
                    'fakultas','phone','alamat','foto'
                ));

                if (!$mahasiswas) throw new \Exception('Oops! something error, please try again!');
                return response()->json([
                    'success' => true,
                    'message' => 'Data has been created!',
                    'data' => $mahasiswas
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }
        }
    }

    public function show($id)
    {
        try {
            $mahasiswas = Mahasiswa::where('id', $id)->first();
            if(empty($mahasiswas)){
                return response()->json([
                    'success' => false,
                    'message' => "No data"
                ], 206);
            } 
            return new MahasiswaResource($mahasiswas);
        } catch (Exception $e) {

        }

        // try {
        //     $mahasiswas = \DB::select(\DB::raw("SELECT * FROM mahasiswas WHERE id = '$id'"));
        //     if (!$mahasiswas) throw new \Exception('No data found');
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Detail Mahasiswa',
        //         'data' => $mahasiswas
        //     ], 200);
        // }catch (\Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => $e->getMessage()
        //     ], 404);
        // }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:32',
            'npm' => 'required|size:8',
            'kelas' => 'required|size:5',
            'jurusan' => 'required|max:64',
            'angkatan' => 'required|size:4'
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ], 400);
        }else{
            try {
                $mahasiswas = Mahasiswa::where('id', $id)->update($request->all());
                if (!$mahasiswas) throw new \Exception('Oops! something error, please try again!');
                return response()->json([
                    'success' => true,
                    'message' => 'Data has been updated!',
                    'data' => $mahasiswas
                ], 200);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }
        }
    }

    public function destroy($id)
    {
        try {
            Mahasiswa::where('id', $id)->delete();
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

    public function detail(Request $Request, $id){

    }
}
