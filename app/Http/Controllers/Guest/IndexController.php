<?php

namespace App\Http\Controllers\Guest;

use App\Subscription;
use App\TypeSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    

    public function index(Request $request){
        if($request->search){
            $search=$request->search;
        }else{
            $search="";
        }

        $suscripciones = Subscription::where(function ($query) use ($search) {
            $query->where('nombre', 'LIKE', '%'.$search.'%');
        })->paginate(9);

        $typeSubscriptions = TypeSubscription::all();
        return view('guest.index',compact('suscripciones','typeSubscriptions'));
    }
    
    
}
