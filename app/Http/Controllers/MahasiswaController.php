<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function index()
    {
        try {
            $mahasiswas = (new Mahasiswa())->findMahasiswa();
            return response()->json([
                'success' => true,
                'message' =>'Mahasiswa has been fetched!',
                'data'    => $mahasiswas
            ], 200);

        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:32',
            'npm' => 'required|size:8',
            'kelas' => 'required|size:5'
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
            $mahasiswas = \DB::select(\DB::raw("SELECT * FROM mahasiswas WHERE id = '$id'"));
            if (!$mahasiswas) throw new \Exception('No data found');
            return response()->json([
                'success' => true,
                'message' => 'Detail Mahasiswa',
                'data' => $mahasiswas
            ], 200);
        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:32',
            'npm' => 'required|size:8',
            'kelas' => 'required|size:5'
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
}
