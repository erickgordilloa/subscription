<?php

namespace App\Http\Controllers;
use App\Customer;
use App\Card;
use App\UserSubscription;
use App\Transaction;
use Illuminate\Http\Request;
use App\Mail\SendNotification;
use Illuminate\Support\Facades\Mail;
use ServicesData;

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
	 	$results = UserSubscription::with('user')->with('brand')->with('type')->with('subscription')->with('typeSubscription')->get();
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

	public function cobrarUser(Request $request)
	{
		try{
			return $this->debitTokenUser($request->id);
		}catch (Exception $e) {
            return response()->json(['msg' => 'error', 'data' => 'Ocurrio un error al guardar transaccion, '.$e->getMessage()]);
        }
	}

	public function debitTokenUser($idUserSuscription){
		try {
            $userSubscription = UserSubscription::with('subscription')->with('user')->whereRaw('number_payment < total_payment')->find($idUserSuscription);
			if(empty($userSubscription)){
				return response()->json(['msg' => 'error', 'data' => 'El cliente ya completo el número de pagos para esta suscripción']);
			}
			$card = Card::where('user_id',$userSubscription->user_id)->where('default_debit',true)->first();
			if(empty($card)){
				return response()->json(['msg' => 'error', 'data' => 'El cliente no tiene registrada ninguna tarjeta para proceder con el debito']);
			}
			
			//guardar los que no tienen tarjetas
			$numberDebit = $userSubscription->number_payment + 1;
			$datos = [
				'id'=>"$userSubscription->user_id",
				'email'=>$userSubscription->user->email,
				'amount_without_tax'=>$userSubscription->subscription->monto_sin_impuesto ?? 0,
                'tax'=>$userSubscription->subscription->impuesto ?? 0,
				'amount'=>$userSubscription->subscription->monto,
				'description'=>"Debito N. $numberDebit",
				'dev_reference'=>"$idUserSuscription",
				'cardToken'=>$card->token
			];
			ServicesData::saveTransactionHistory([
				"transaction_id"=>0,
				"user_id"=>$userSubscription->user_id,
				"action"=>"DEBIT TOKEN SEND DATA",
				"response"=>json_encode($datos)
			]);
			$response = ServicesData::debitToken($datos);
			ServicesData::saveTransactionHistory([
				"transaction_id"=>0,
				"user_id"=>$userSubscription->user_id,
				"action"=>"DEBIT TOKEN RESPONSE DATA",
				"response"=>json_encode($response)
			]);
			//enviar correo
			if (!empty($response)) {
				if(empty($response['error'])){
					#guardar transaccion
					$transaction = $this->saveTransaction($response,$userSubscription->user_id,$userSubscription->subscription->id,$card->id);
					if($response['transaction']['status'] == 'success'){
						$transaction = Transaction::with('subscription')->with('user')->where('transactions.id',$transaction->id)->first();
						Mail::to($userSubscription->user->email)->cc(env('EMAIL_COPY'))->send(new SendNotification($transaction));
						$userSubscription->number_payment = $numberDebit;
						$userSubscription->save();#actualizo el numero de pago
					}
				}
			}  
            $result = $response['transaction']['status'] == "success" ? ['msg' => 'success', 'data' => 'Cobro realizado con éxito'] : ['msg' => 'error', 'data' => "El cobro no pudo ser procesado"];
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['msg' => 'error', 'data' => 'Ocurrio un error, '.$e->getMessage()]);
        }
	}  

	public function saveTransaction($request,$user_id,$subscription_id,$card_id){
		try {
			##$transaction = Transaction::find($request->dev_reference);
			$transaction = new Transaction;
			$transaction->user_id = $user_id;
			$transaction->subscription_id = $subscription_id;
			$transaction->card_id = $card_id;
			$transaction->authorization_code = $request['transaction']['authorization_code'];
			$transaction->amount = $request['transaction']['amount'];
			$transaction->carrier_code = $request['transaction']['carrier_code'];
			$transaction->dev_reference = $request['transaction']['dev_reference'];
			$transaction->id_response = $request['transaction']['id'];
			$transaction->message = $request['transaction']['message'];
			$transaction->payment_date = $request['transaction']['payment_date'];
			$transaction->transaction_reference = $request['card']['transaction_reference'];
			$transaction->status = $request['transaction']['status'];
			$transaction->status_detail = $request['transaction']['status_detail'];
			$transaction->save();
			return $transaction;
		} catch (Exception $e) {
            return response()->json(['msg' => 'error', 'data' => 'Ocurrio un error al guardar transaccion, '.$e->getMessage()]);
        }
	}

	
}
