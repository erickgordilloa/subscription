<?php

namespace App\Http\Controllers\Guest;

use App\Subscription;
use App\TypeSubscription;
use App\Brand;
use App\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    

    public function index(Request $request){
        $search="";
        if($request->q){
            $search=$request->q;
        }

        $suscripciones = Subscription::where(function ($query) use ($search) {
            $query->where('nombre', 'LIKE', '%'.$search.'%')->orWhere('detalle', 'LIKE', '%'.$search.'%');
        })->paginate(9);

        $typeSubscriptions = TypeSubscription::all();
        $brands = Brand::all();
        $types = Type::all();
        return view('guest.index',compact('suscripciones','typeSubscriptions','search','brands','types'));
    }
    
    
}
