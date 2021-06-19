<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        try {
            $mahasiswas = \DB::table('mahasiswas')->get();
            if ($mahasiswas->isEmpty()) 
            {
                return response()->json([
                    'success' => false,
                    'message' => 'No data found'
                ], 404);
            }else{
                return response()->json([
                    'success' => true,
                    'message' =>'Mahasiswa has been fetched!',
                    'data'    => $mahasiswas
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }

    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'npm' => 'required',
            'kelas' => 'required'
        ]);

        if ($validator->fails()) 
        {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 401);
        }else{
            try {
                $mahasiswas = Mahasiswa::create($request->all());
                return response()->json([
                    'success' => true,
                    'message' => 'Data has been created!',
                    'data' => $mahasiswas
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 400);
            }
        }
    }

    public function show($id)
    {
        try {
            $mahasiswas = \DB::select(\DB::raw("SELECT * FROM mahasiswas WHERE id = '$id'"));
            if (empty($mahasiswas)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No data found'
                ], 404);

            }else{
                return response()->json([
                    'success' => true,
                    'message' => 'Detail Mahasiswa',
                    'data' => $mahasiswas
                ], 200);
            }
        }catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
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
                'message' => $validator->errors()
            ], 401);
        }else{
            try {
                $mahasiswas = Mahasiswa::update($request->all());
                return response()->json([
                    'success' => true,
                    'message' => 'Data has been updated!',
                    'data' => $mahasiswas
                ], 200);
            } catch (Exception $e) {
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
            $mahasiswas = \DB::table('mahasiswas')->where('id', $id)->delete();
            return response()->json([
                'success' => true,
                'message' => "Data successfully deleted!"
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
