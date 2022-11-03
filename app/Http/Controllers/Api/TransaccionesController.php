<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaction;
use App\Mail\SendNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Carbon\Carbon;

class TransaccionesController extends Controller
{
    public function transaccion(Request $request) {

    	try {

    		#return $request['transaction']['dev_reference'];
    		$transaction = Transaction::where('id_response',$request['transaction']['id'])->first();

    		if (!$transaction) {
	            return response()->json([
	                'status' => 'error',
	                'message' => 'transaction not found.'
	            ], 200);
	        }

	        $status = "pending";
	        if ($request['transaction']['status']==1||$request['transaction']['status']==3) {
	        	$status = "success";
	        }elseif ($request['transaction']['status']==2) {
	        	$status = "cancelled";
	        }elseif ($request['transaction']['status']==4) {
	        	$status = "rejected";
	        }elseif ($request['transaction']['status']==5) {
	        	$status = "expired";
	        }

			$transaction->authorization_code = $request['transaction']['authorization_code'];
			$transaction->carrier_code = $request['transaction']['carrier_code'];
			$transaction->dev_reference = $request['transaction']['dev_reference'];
			$transaction->id_response = $request['transaction']['id'];
			$transaction->message = $request['transaction']['message'];
			$transaction->payment_date = $request['transaction']['paid_date'];
			$transaction->transaction_reference = $request['transaction']['order_description'];
			$transaction->status = $status;
			$transaction->status_detail = $request['transaction']['status_detail'];
			$transaction->save();

			$transaction = Transaction::with('subscription')->with('user')->where('transactions.id',$transaction->id)->first();

			if (!empty($transaction) && $transaction->status == 'success') {
				Mail::to($transaction->user->email)->send(new SendNotification($transaction));
			}    		

    		return response()->json(
                    [
                        'status' => 'success',
                        'message' => 'complete information'
                    ],204);

    	} catch (Exception $e) {
    		return response()->json(
                    [
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ],200);
    	}

		
	}

	public function getCards(Request $request) {

    	try {
			$SERVER_APP_CODE = env('SERVER_APP_CODE');
			$SERVER_APP_KEY = env('SERVER_APP_KEY');
			$server_application_code = $SERVER_APP_CODE;
			$server_app_key = $SERVER_APP_KEY;
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

			$url = "/v2/card/list?uid=$request->uid";

			$response  = $client->request('GET',$url);

			$response = json_decode($response->getBody(), true);

			return $response;

			/* if ($response['status'] == "success") {
				$transaction = Transaction::where('id_response',$request->id_response)->first();
				$transaction->refund = 'SI';
				$transaction->detail_refund = $request->detalle;
				$transaction->user_refund = auth()->user()->id;
				$transaction->date_refund = Carbon::now();
				$transaction->save();
				return $transaction ? ['status' => 'success', 'detail' => 'Reembolso realizado con éxito'] : ['status' => 'error', 'detail' => 'Ocurrio un error al realizar la transacción'];
			}else{
				return $response;
			} */

		} catch (Exception $e) {
			
			return response()->json(
				[
					'status' => 'error',
					'message' => $e->getMessage()
				],400);
		}

		
	}
	
	public function deleteCards(Request $request) {

    	try {
			$SERVER_APP_CODE = env('SERVER_APP_CODE');
			$SERVER_APP_KEY = env('SERVER_APP_KEY');
			$server_application_code = $SERVER_APP_CODE;
			$server_app_key = $SERVER_APP_KEY;
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
				'card'=>[
					'token'=>$request->cardToken
				],
				'user'=>[
					'id'=>$request->uid
					]
				];
				\Log::info("api ".json_encode($body)); 
			//return $body;
			$url = "/v2/card/delete/";

			$response  = $client->request('POST',$url, [
			    'body' => json_encode($body) ,
				'http_errors' => false
			]);

			$response = json_decode($response->getBody(), true);

			return $response;

		} catch (Exception $e) {
			
			return response()->json(
				[
					'status' => 'error',
					'message' => $e->getMessage()
				],400);
		}
	}
	public function debits(Request $request) {
    	try {
			
			$datos = [
				'id'=>'2',
				'email'=>'jhon@doe.com',
				'amount'=>50,
				'description'=>'test',
				'dev_reference'=>'test-11',
				'cardToken'=>'599129338774818021'
			];
			$response = $this->debitToken($datos);

			return $response;

		} catch (Exception $e) {
			
			return response()->json(
				[
					'status' => 'error',
					'message' => $e->getMessage()
				],400);
		}
	}


	public function debitToken($datos = []){
		try {
			$SERVER_APP_CODE = env('SERVER_APP_CODE');
			$SERVER_APP_KEY = env('SERVER_APP_KEY');
			$server_application_code = $SERVER_APP_CODE;
			$server_app_key = $SERVER_APP_KEY;
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
				'user'=>[
					'id'=>$datos['id'],
					'email'=>$datos['email']
				],
				'order'=>[
					'amount'=>$datos['amount'],
					'description'=>$datos['description'],
					'dev_reference'=>$datos['dev_reference'],
					'vat'=> 0,
					'tax_percentage'=> 0
				],
				'card'=>[
					'token'=>$datos['cardToken'],
				]
			];

			$url = "/v2/transaction/debit/";

			$response  = $client->request('POST',$url, [
			    'body' => json_encode($body) 
			]);

			$response = json_decode($response->getBody(), true);

			return $response;

		} catch (Exception $e) {
			
			return response()->json(
				[
					'status' => 'error',
					'message' => $e->getMessage()
				],400);
		}
	}
}
