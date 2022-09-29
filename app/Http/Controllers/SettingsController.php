<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingsController extends Controller
{
    public function __construct() {
		$this->middleware('auth');
	}

	public function index()
	{
		return view('settings.index');
	}

	public function data(Request $request)
	{
		$results = Setting::where('id',1)->get();
		return view('settings.tabla',compact('results'));
	}

	public function store(Request $request)
	{
		$settings = Setting::find(1);
		$settings->text_transferencia = $request->transferencia;
		$settings->text_ayuda = $request->ayuda_social;
		$settings->max_monto = $request->monto_maximo;
		$settings->save();
		$result = $settings ? ['msg' => 'success', 'data' => 'Se ha actualizado correctamente']: ['msg' => 'error', 'data' => 'Ocurrio un error al actualizar información'];
		return response()->json($result);
	}
}
