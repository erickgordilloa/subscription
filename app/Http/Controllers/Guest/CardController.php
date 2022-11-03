<?php

namespace App\Http\Controllers\Guest;

use App\Card;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use ServicesData;

class CardController extends Controller
{
    public function __construct() {
		$this->middleware('auth');
	}

    public function index(Request $request){
        return view('guest.card');
    }
    
    public function data(Request $request){
        $results = ServicesData::getCards(auth()->user()->id);
        //$results = Card::where('user_id',auth()->user()->id)->get();
        return view('guest.cardTabla', compact('results'));
    }
   
    public function create(Request $request){
        try {
            Card::where('user_id', auth()->user()->id)->update(['default_debit' => false]);

            $response = $request['response']['card'];
            $card = new Card;
            $card->user_id = auth()->user()->id;
            $card->token = $response['token'];
            $card->status = $response['status'];
            $card->transaction_reference = $response['transaction_reference'];
            $card->expiry_month = $response['expiry_month'];
            $card->expiry_year = $response['expiry_year'];
            $card->bin = $response['bin'];
            $card->number = $response['number'];
            $card->type = $response['type'];
            $card->response = json_encode($request['response']);
            $card->default_debit = true;
            $card->save();

            $result = $card ? ['msg' => 'success', 'data' => 'Tarjeta agregada con éxito']: ['msg' => 'error', 'data' => 'Ocurrio un error al actualizar información'];
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['msg' => 'error', 'data' => 'Ocurrio un error, '.$e->getMessage()]);
        }
    }

    public function delete(Request $request){
        $card = Card::where("token",$request->cardToken)->first();
        if(!empty($card)){
            $card->delete();
            $default = Card::where("user_id",auth()->user()->id)->where("status","valid")->first();
            if(!empty($default)){
                $default->update(['default_debit' => true]);
            }
        }
        //return $request->cardToken;
        $response = ServicesData::deleteCard($request->cardToken,auth()->user()->id);
        $result = !empty($response['error']) ? ['msg' => 'error', 'data' => $response['error']['description']] : ['msg' => 'success', 'data' => 'Tarjeta eliminada con éxito'];
        return response()->json($result);
    }

}
