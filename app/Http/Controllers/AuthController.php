<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AuthController extends Controller
{

	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => 'required|unique:users|max:64',
			'password' => 'required|min:6|confirmed'
		]);

		if ($validator->passes()) 
		{
			$user = new User([
				'email' => $request->email
			]);
			$user->password = Hash::make($request->password);
			$user->save();

			return response()->json([
				'success' => true,
				'message' => 'Register succesfully!',
			], 200);
		}else{
			return response()->json([
				'success' => false,
				'message' => $validator->errors()->all()
			], 400);
		}
	}

	public function authenticate(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => 'required',
			'password' => 'required'
		]);

		$email = $request->email;
		$password =  $request->password;
		$api_token = base64_encode(Str::random(25));

		if ($validator->passes()) 
		{
			$user = User::where('email', $email)->first();

			if ($user) {
				$check = Hash::check($password, $user->password);

				if ($check) {
					$user->api_token = $api_token;
					$user->save();
					$response = [
						'success' => true,
						'message' => 'Login succesfully!',
						'data' => $user->api_token
					];
					$status = 200;

				}else{
					$response = [
						'success' => false,
						'message' => 'Wrong password!'
					];
					$status = 401;
				}

			}else{
				$response = [
					'success' => false,
					'message' => 'Account doesn\'t exist!'
				];
				$status = 401;
			}

		}else{
			$response = [
				'success' => false,
				'message' => $validator->errors()->all()
			];
			$status = 400;
		}

		return response()->json($response,$status);
	}
}