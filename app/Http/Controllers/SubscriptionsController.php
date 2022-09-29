<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscription;
use App\SubscriptionFiles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubscriptionsController extends Controller
{
    public function __construct() {
		$this->middleware('auth');
	}

	public function index() {

		return view('subscriptions');
	}

	public function data() {
		$results = Subscription::all();

		return view('subscriptions.tabla', compact('results'));
	}

	public function create(Request $request)
	{
		//return $request;
		try {
			if (empty($request->id)) {
				$subscription = new Subscription;
				$subscription->nombre =  $request->nombre;
				$subscription->detalle =  $request->detalle;
				$subscription->monto =  $request->monto;
				$subscription->es_editable =  $request->es_editable;
				$subscription->estado =  $request->estado;
				$subscription->texto =  $request->texto;
				$subscription->save();

				$adjuntos = $request->file('archivo');
				if (!empty($adjuntos)) {
					foreach ($adjuntos as $file) {
						$file->store('adjuntos');
						$archivo =  new SubscriptionFiles;
						$archivo->subscription_id = $subscription->id;
						$archivo->archivo = $adjuntos;
						$archivo->save();
					}
				}
				return response()->json(['msg' => 'success', 'data' => 'Se ha creado correctamente el Tipo ' . $request->nombre]);
			}else{
				$subscription = Subscription::find($request->id);
				$subscription->nombre =  $request->nombre;
				$subscription->detalle =  $request->detalle;
				$subscription->monto =  $request->monto;
				$subscription->es_editable =  $request->es_editable;
				$subscription->estado =  $request->estado;
				$subscription->texto =  $request->texto;
				$subscription->save();

				
				return response()->json(['msg' => 'success', 'data' => 'Se ha actualizado correctamente el Tipo ' . $request->nombre]);
			}
		} catch (Exception $e) {
			return response()->json(['msg' => 'error', 'data' => $e->getMessage()]);
		}
	}

	public function archivos(Request $request)
	{
		return SubscriptionFiles::where('subscription_id',$request->id)->get();
	}

	public function files(Request $request)
	{
		$nombre = Str::replaceArray(' ', ['_'], trim($request->nombre));
		$file = $request->file('archivo');
    	$file->storeAs('public/adjuntos/'.$request->subscription_id, $request->nombre.'.'.$file->extension());
        $archivo =  new SubscriptionFiles;
		$archivo->subscription_id = $request->subscription_id;
		$archivo->archivo = $request->nombre.'.'.$file->extension();
		$archivo->save();

		return response()->json(['msg' => 'success', 'data' => 'Se ha guardado correctamente el archivo ' . $request->nombre]);
	}

	public function deleteFile(Request $request){
		$eliminar = SubscriptionFiles::find($request->id)->delete();

		return response()->json(['msg' => 'success', 'data' => 'Se ha guardado correctamente el archivo ']);
	}
	
}
