<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function __construct() {
		$this->middleware('auth');
	}

    public function index(){
        return view('guest.perfil');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
			'name' => ['required', 'string', 'max:255'],
			'password' => ['required', 'string', 'min:8', 'confirmed'],
		]);
    }
    protected function validatorDir(array $data)
    {
        return Validator::make($data, [
			'provincia' => ['required', 'string', 'max:255'],
			'direccion' => ['required', 'string', 'max:255'],
			'ciudad' => ['required', 'string', 'max:255'],
			'telefono' => ['required', 'string', 'max:15'],
		]);
    }
    protected function validatorFact(array $data)
    {
        return Validator::make($data, [
			'provincia_fac' => ['required', 'string', 'max:255'],
			'ciudad_fac' => ['required', 'string', 'max:255'],
			'direccion_fac' => ['required', 'string', 'max:255'],
			'documento_identidad' => ['required', 'string', 'max:13'],
		]);
    }

    public function data(Request $request) {
        $this->validator($request->all())->validate();
        $user = User::find(auth()->user()->id);
        $user->password = Hash::make($request['password']);
        $user->save();
        return \Redirect::back()->with('message', 'Datos actualizados');
	}
    
    public function direccion(Request $request) {
        $this->validatorDir($request->all())->validate();
        $user = User::find(auth()->user()->id);
        $user->provincia =$request['provincia'];
        $user->direccion =$request['direccion'];
        $user->ciudad =$request['ciudad'];
        $user->telefono =$request['telefono'];
        $user->save();
        return \Redirect::back()->with('message', 'Datos de dirección actualizados');
	}
    
    public function factura(Request $request) {
        $this->validatorFact($request->all())->validate();
        $user = User::find(auth()->user()->id);
        $user->provincia_fac = $request['provincia_fac'];
        $user->ciudad_fac = $request['ciudad_fac'];
        $user->direccion_fac = $request['direccion_fac'];
        $user->documento_identidad = $request['documento_identidad'];
        $user->save();
        return \Redirect::back()->with('message', 'Datos facturación actualizados');
	}

    
}
