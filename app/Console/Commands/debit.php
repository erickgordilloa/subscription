<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Card;
use App\UserSubscription;
use App\Transaction;
use ServicesData;
use App\Mail\SendNotification;
use Illuminate\Support\Facades\Mail;

class debit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debit:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debito automatico';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        #llamar a todas  las personas
        $filename = "sucription_" . date("Y-m-d H:i:s") . ".txt";
        try {
            \Storage::append($filename,"INICIO");
            $AllUsers = UserSubscription::with('subscription')->with('user')->whereRaw('number_payment < total_payment')->get();
            \Storage::append($filename,"All user --> ".json_encode($AllUsers));
            foreach($AllUsers as $userSubscription){
                $card = Card::where('user_id',$userSubscription->user_id)->where('default_debit',true)->first();
                if(empty($card->token)){
                    \Storage::append($filename,"User $userSubscription->user_id --> Not card Token user ");
                    ServicesData::saveTransactionHistory([
                        "transaction_id"=>0,
                        "user_id"=>$userSubscription->user_id,
                        "action"=>"DEBIT CARD NOT FOUND",
                        "response"=>""
                    ]);
                    continue;
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
                    'dev_reference'=>"$userSubscription->id",
                    'cardToken'=>$card->token
                ];
                ServicesData::saveTransactionHistory([
                    "transaction_id"=>0,
                    "user_id"=>$userSubscription->user_id,
                    "action"=>"DEBIT TOKEN SEND DATA",
                    "response"=>json_encode($datos)
                ]);
                $response = ServicesData::debitToken($datos);
                \Storage::append($filename,"userSubscription $userSubscription->id Response debit --> " . json_encode($response));
                ServicesData::saveTransactionHistory([
                    "transaction_id"=>0,
                    "user_id"=>$userSubscription->user_id,
                    "action"=>"DEBIT TOKEN RESPONSE DATA",
                    "response"=>json_encode($response)
                ]);
                //enviar correo
                if (!empty($response)) {
                    #guardar transaccion
                    if(empty($response['error'])){
                        $transaction = $this->saveTransaction($response,$userSubscription->user_id,$userSubscription->subscription->id,$card->id);
                        if($transaction){
                            ServicesData::saveTransactionHistory([
                                "transaction_id"=>$transaction->id,
                                "user_id"=>$userSubscription->user_id,
                                "action"=>"TRANSACTION SAVE",
                                "response"=>json_encode($transaction)
                            ]);
                        }
                        if($response['transaction']['status'] == 'success'){
                            $transaction = Transaction::with('subscription')->with('user')->where('transactions.id',$transaction->id)->first();
                            Mail::to($userSubscription->user->email)->cc(env('EMAIL_COPY'))->send(new SendNotification($transaction));
                            \Storage::append($filename,"userSubscription $userSubscription->id Send Mail --> " . $userSubscription->user->email);
                        }
                        $userSubscription->number_payment = $numberDebit;
                        $userSubscription->save();#actualizo el numero de pago
                    }
                }  
            }
            \Storage::append($filename,"FIN");
        } catch (Exception $e) {
            \Storage::append($filename,"ERROR --> ".$e->getMessage());
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
            return 'Ocurrio un error al guardar transaccion, '.$e->getMessage();
        }
    }
    
}

