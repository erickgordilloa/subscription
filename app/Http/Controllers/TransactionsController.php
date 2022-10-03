<?php

namespace App\Http\Controllers;
use App\Transaction;
use App\Subscription;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\SendNotification;
use Illuminate\Support\Facades\Mail;

class TransactionsController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		$estados = Transaction::select('status')->distinct()->get();
		$subscriptions = Subscription::where('estado','A')->get();
		//return $estados;
		return view('transacciones',compact('estados','subscriptions'));
	}

	public function data(Request $request) {
		$results = Transaction::with('tipo')->with('user')->orderBy('created_at','DESC')
		->whereBetween('transactions.created_at', [$request->fecha_ini.' 00:00:00', $request->fecha_fin.' 23:59:59'])
		->where('transactions.status','like',"%$request->estado%")
		->get();

		return view('transacciones.tabla', compact('results'));
	}

	public function export(Request $request) {
		//return  $request;
		return Excel::download(new TransactionExport($request->fecha_inicio.' 00:00:00', $request->final.' 23:59:59',$request->estado_export),'transacciones.xlsx');
	}

	public function refund(Request $request)
	{
		try {
			$SERVER_APP_CODE = env('SERVER_APP_CODE');
			$SERVER_APP_KEY = env('SERVER_APP_KEY');
			$server_application_code = $SERVER_APP_CODE;
			$server_app_key = $SERVER_APP_KEY ;
			$date = new \DateTime();
			$unix_timestamp = $date->getTimestamp();
			$uniq_token_string = $server_app_key.$unix_timestamp;
			$uniq_token_hash = hash('sha256', $uniq_token_string);
			$auth_token = base64_encode($server_application_code.";".$unix_timestamp.";".$uniq_token_hash);
		
			$baseUrl = env('API_ENDPOINT');

			$headers = [
			    'Accept' => 'application/json',
			  	"Content-Type", "application/x-www-form-urlencoded",
			    'Auth-Token' => $auth_token,
			];

			$client = new Client([
				'base_uri' => $baseUrl,
				'headers' => $headers
			]);

			$body = [
				'transaction'=>[
					'id'=>$request->id_response
				]
			];

			$response  = $client->request('POST','v2/transaction/refund/', [
			    'body' => json_encode($body) 
			]);

			$response = json_decode($response->getBody(), true);

			if ($response['status'] == "success") {
				$transaction = Transaction::where('id_response',$request->id_response)->first();
				$transaction->refund = 'SI';
				$transaction->detail_refund = $request->detalle;
				$transaction->user_refund = auth()->user()->id;
				$transaction->date_refund = Carbon::now();
				$transaction->save();
				return $transaction ? ['status' => 'success', 'detail' => 'Reembolso realizado con éxito'] : ['status' => 'error', 'detail' => 'Ocurrio un error al realizar la transacción'];
			}else{
				return $response;
			}

		} catch (Exception $e) {
			
			return ['status' => 'success', 'detail' => $e->getMessage()];
		}

	}

	public function resend(Request $request)
	{
		$transaction = Transaction::with('tipo')->with('tipo.adjunto')->with('user')->where('transactions.id',$request->id)->first();

		if (!empty($transaction->user->email) && $transaction->status == 'success') {
			Mail::to($transaction->user->email)->cc(env('EMAIL_COPY'))->send(new SendNotification($transaction));
		}

		return response()->json(['msg' => 'success', 'data' => 'Correo reenviado correctamente.']);
	}

	public function subscription(Request $request)
	{
		$transaction =  Transaction::find($request->transaccion_id);
		$transaction->reference = $request->reference;
		$transaction->save();

		return response()->json(['msg' => 'success', 'data' => 'Tipo de subscription actualizado correctamente.']);
	}
}
