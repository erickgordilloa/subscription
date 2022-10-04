<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller {
	/*
		    |--------------------------------------------------------------------------
		    | Register Controller
		    |--------------------------------------------------------------------------
		    |
		    | This controller handles the registration of new users as well as their
		    | validation and creation. By default this controller uses a trait to
		    | provide this functionality without requiring any additional code.
		    |
	*/

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::HOME;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	/* public function __construct() {
		$this->middleware('auth');
	} */
	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data) {
		return Validator::make($data, [
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return \App\User
	 */
	protected function create(array $data) {
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
		]);
	}

	public function register(Request $request) {
		try {
			if (empty($request->id)) {
				$user = new User;
				$user->name =  $request->name;
				$user->email =  $request->email;
				$user->role_id = 1;
				$user->password =  Hash::make($request->password);
				$user->save();
				return response()->json(['msg' => 'success', 'data' => 'Se ha creado correctamente el usuario ' . $request->name]);
			}else{
				$user = User::find($request->id);
				$user->name =  $request->name_edit;
				$user->email =  $request->email_edit;
				$user->save();
				return response()->json(['msg' => 'success', 'data' => 'Se ha actualizado correctamente el usuario ' . $request->name_edit]);
			}
		} catch (Exception $e) {
			return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
		}
	}

	public function delete(Request $request)
	{
		$user = User::find($request->id);
		$user->status =  'I';
		$user->save();
		return response()->json(['msg' => 'success', 'data' => 'Se ha elimando correctamente el usuario ' . $request->name_edit]);
	}

	public function index() {
		return view('usuarios');
	}

	public function data() {
		$results = User::where('status','A')->where('role_id',1)->get();
		return view('usuarios.tabla', compact('results'));
	}
}
