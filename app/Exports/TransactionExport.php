<?php

namespace App\Exports;

use App\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
class TransactionExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
   	public $fecha_ini;
   	public $fecha_fin;
   	public $estado;

    public function __construct($fecha_ini,$fecha_fin,$estado)
    {
        $this->fecha_ini = $fecha_ini;
        $this->fecha_fin = $fecha_fin;
        $this->estado = $estado;
    }
    public function collection()
    {
		return  Transaction::with('tipo')->with('user')->orderBy('created_at','DESC')
		->whereBetween('transactions.created_at', [$this->fecha_ini, $this->fecha_fin])
		->where('transactions.status','like',"%$this->estado%")
		->get();
    }

    public function headings():array
    {
    	return [
    		'Nombres',
    		'Apellidos',
    		'Documento',
    		'Correo',
    		'Código de Autorización',
    		'ID de la transacción',
    		'Monto',
    		'Referencia',
    		'Fecha de registro',
            'Fecha Transacción',
    		'Comentario',
    		'Estado',
    		'Reembolsado',
    	];
    }

     public function map($transaction): array {
        return [
            $transaction->user->name,
            '$transaction->persona->apellido',
            '$transaction->persona->identidad',
            $transaction->user->email,
            $transaction->authorization_code,
            $transaction->id_response,
            $transaction->amount,
            $transaction->tipo->nombre,
            Carbon::parse($transaction->created_at)->toFormattedDateString(),
            //Carbon::parse($transaction->payment_date)->toFormattedDateString(),
            $transaction->payment_date,
            $transaction->comentario,
            $transaction->status,
            $transaction->refund
        ];
 
 
    }
}
