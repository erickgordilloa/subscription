<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use GuzzleHttp\Client;
use Carbon\Carbon;

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

	public static function deleteCard($userId, $cardToken) {
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
					'token'=>$cardToken
				],
				'user'=>[
					'id'=>$userId
				]
			];
			$url = "/v2/card/delete/";
			$response  = $client->request('POST',$url, [
			    'body' => json_encode($body) 
			]);
			$response = json_decode($response->getBody(), true);
			return $response;
		} catch (Exception $e) {
			return response()->json([
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