<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use GuzzleHttp\Client;
use App\TransactionHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServicesData
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }
    
    public static function getCards($userId)
    {
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

			$url = "/v2/card/list?uid=$userId";
			$response  = $client->request('GET',$url);
			$response = json_decode($response->getBody()->getContents(), true);

			return $response;

		} catch (Exception $e) {
			return response()->json(
				[
					'status' => 'error',
					'message' => $e->getMessage()
				],400);
		}
    }

	public static function deleteCard($cardToken,$uid) {
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
					'token'=>"$cardToken"
				],
				'user'=>[
					'id'=>"$uid"
				]
			];
			
			$url = "/v2/card/delete/";

			$response  = $client->request('POST',$url, [
			    'body' => json_encode($body),
				'http_errors' => false
			]);

			return json_decode($response->getBody(), true);


		} catch (Exception $e) {
			
			return response()->json(
				[
					'status' => 'error',
					'message' => $e->getMessage()
				],400);
		}
	}

	public static function debitToken($datos = []){
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

			$tax_percentage = intval(env('TAX_PERCENTAGE'));#12

			if($tax_percentage > 0 && $datos['tax'] == 0){
				return ['error' => ['description' => "Por favor configure los impuestos antes de procesar el cobro"]];
			}

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
					'vat'=> $datos['tax'],
					'taxable_amount'=> $datos['amount_without_tax'],
					'tax_percentage'=> $tax_percentage
				],
				'card'=>[
					'token'=>$datos['cardToken'],
				]
			];

			self::saveTransactionHistory([
				"transaction_id"=>0,
				"user_id"=>$datos['id'],
				"action"=>"DEBIT TOKEN SEND BODY",
				"response"=>json_encode($body)
			]);

			$url = "/v2/transaction/debit/";

			$response  = $client->request('POST',$url, [
			    'body' => json_encode($body),
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

	public static function saveTransactionHistory($request = []){
		try {
            if(!empty($request)){
                $transactionHistory = new TransactionHistory;
                $transactionHistory->transaction_id = $request['transaction_id'];
                $transactionHistory->user_id = $request['user_id'];
                $transactionHistory->action = $request['action'];
                $transactionHistory->response = $request['response'];
                $transactionHistory->save();
                return $transactionHistory;
            }
		} catch (Exception $e) {
            return 'Ocurrio un error al guardar transaccion, '.$e->getMessage();
        }
	}

    
}