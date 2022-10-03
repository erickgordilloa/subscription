<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Transaction;
use App\Subscription;
use App\Setting;
use App\Mail\SendNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class DonacionesController extends Controller {

	public function index() {
		$ofrendas = Subscription::where('estado', 'A')->get();
		$settings = Setting::find(1);
		return view('web.body', compact('ofrendas','settings'));
	}

	public function create(Request $request) {
		try {
			DB::beginTransaction();

			$customer = Customer::where('identidad', $request->cedula)->first();

			$settings = Setting::find(1);

			if ($request->monto>$settings->max_monto) {
				return response()->json([
	                'status' => 'warning',
	                'message' => 'El monto máximo por transacción es $'.$settings->max_monto
	            ], 200);
			}

			if (empty($customer)) {
				$customer = new Customer;
				$customer->nombre = $request->nombre;
				$customer->apellido = $request->apellido;
				$customer->tipo_identidad = $request->tipo_identidad;
				$customer->identidad = $request->cedula;
				$customer->correo = $request->correo;
				$customer->direccion = $request->direccion;
				$customer->celular = $request->celular;
				$customer->save();
			}

			$transaction = new Transaction;
			$transaction->user_id = $customer->id;
			$transaction->amount = $request->monto;
			$transaction->comentario = $request->comentario;
			$transaction->subscription_id = $request->tipo;
			$transaction->status = "pending";
			$transaction->save();

			DB::commit();

			return response()->json([
	                'status' => 'success',
	                'data' => $transaction
	            ], 200);

		} catch (Exception $e) {
			  DB::rollBack(); 
			  return response()->json([
	                'status' => 'error',
	                'message' => $e->getMessage()
	            ], 200);
		}
		
	}
	public function donacion(Request $request) {

		$transaction = Transaction::find($request->dev_reference);
		$transaction->authorization_code = $request->authorization_code;
		$transaction->carrier_code = $request->carrier_code;
		$transaction->dev_reference = $request->dev_reference;
		$transaction->id_response = $request->id_response;
		$transaction->message = $request->message;
		$transaction->payment_date = $request->payment_date;
		$transaction->transaction_reference = $request->transaction_reference;
		$transaction->status = $request->status;
		$transaction->status_detail = $request->status_detail;
		$transaction->save();

		$transaction = Transaction::with('tipo')->with('tipo.adjunto')->with('user')->where('transactions.id',$transaction->id)->first();

		if (!empty($transaction) && $transaction->status == 'success') {
			Mail::to($request->correo)->cc(env('EMAIL_COPY'))->send(new SendNotification($transaction));
		}

		return $transaction;
	}
}
