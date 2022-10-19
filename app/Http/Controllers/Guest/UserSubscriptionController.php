<?php

namespace App\Http\Controllers\Guest;

use App\UserSubscription;
use App\TypeSubscription;
use App\Transaction;
use App\Card;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserSubscriptionController extends Controller
{
    public function __construct() {
		$this->middleware('auth');
	}

    public function suscribir(Request $request){
        try{
            $verifyCard = Card::where('user_id',auth()->user()->id)->count();
            if($verifyCard <= 0){
                return response()->json(['msg' => 'error', 'data' => 'Primero registre una tarjeta una <a href="tarjetas">tarjeta</a>']);
            }
            $total_payment = TypeSubscription::find($request->type_subscription_id);
            $userSubscription = new UserSubscription;
            $userSubscription->user_id = auth()->user()->id;
            $userSubscription->subscription_id = $request->subscription_id;
            $userSubscription->type_subscription_id = $request->type_subscription_id;
            $userSubscription->number_payment = 0;
            $userSubscription->total_payment = $total_payment->month;
            $userSubscription->brand_id = $request->brand_id;
            $userSubscription->type_id = $request->type_id;
            $userSubscription->save();
            $result = $userSubscription ? ['msg' => 'success', 'data' => 'Se ha suscripto con éxito']: ['msg' => 'error', 'data' => 'Ocurrio un error al actualizar información'];
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['msg' => 'error', 'data' => 'Ocurrio un error, '.$e->getMessage()]);
        }
    }

    public function suscripciones(){
         $suscripciones = UserSubscription::with('user')->with('subscription')->with('typeSubscription')->where('user_id',auth()->user()->id)->paginate(10);
        return view('guest.suscripciones',compact('suscripciones'));
    }

    public function delete($id){
        $userSubscription = UserSubscription::find($id);
        $userSubscription->delete();
        return 'ok';
    }

    public function pagos(){
        return view('guest.pagos');
    }
    
    public function pagosData(){
        $results = Transaction::where('user_id',auth()->user()->id)->with('user')->with('card')->with('subscription')->get();
        return view('guest.pagosTabla', compact('results'));
    }
}
