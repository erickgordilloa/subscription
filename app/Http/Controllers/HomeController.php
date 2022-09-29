<?php

namespace App\Http\Controllers;
use App\Customer;
use Illuminate\Http\Request;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index() {
		return view('home');
	}

	public function data() {
		$results = Customer::all();
		return view('personas.tabla', compact('results'));
	}

	public function post(Request $request)
	{
		$persona = Customer::find($request->id);	
		$persona->nombre = $request->nombre ;
		$persona->apellido = $request->apellido ;
		$persona->tipo_identidad = $request->tipo ;
		$persona->identidad = $request->identidad ;
		$persona->correo = $request->correo ;
		$persona->direccion = $request->direccion ;
		$persona->celular = $request->celular ;
		$persona->save();

		return response()->json(['msg' => 'success', 'data' => 'Persona actulizada con exito.']);
	}
}
