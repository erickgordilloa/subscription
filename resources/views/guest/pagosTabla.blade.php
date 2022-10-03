<table id="tbl_pagos" class="table table-bordered">
    <thead>
    <tr>
        <th>Suscripción</th>
        <th>Tarjeta</th>
        <th>Monto</th>
        <th>Detalle</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    {{-- @foreach($results['cards'] as $rst) --}}
    @foreach($results as $rst)
        <tr>
            <td>
                {{$rst->subscription->nombre}}<br/>
            </td>
            <td>
                {{$rst->card->bin}}XXXXXX{{$rst->card->number}}<br/>
            </td>
            <td>
                ${{$rst->amount ? number_format($rst->amount, 2, '.', ',') : '0.00'}}
            </td>
            <td>
                <b>Código de Autorización: </b>{{$rst->authorization_code}}<br>
                <b>Id de la transacción: </b>{{$rst->id_response}} <br>
                @if ($rst->status == "success")
                    <b>Referencia: </b><a href="#" onclick="reference({{ $rst->id }},{{ $rst->tipo->id }})" data-toggle="modal" data-target=".modal-reference" >{{$rst->tipo->nombre}}  <i class="fas fa-edit"></i></a><br>
                @else
                    <b>Referencia: </b>{{$rst->tipo->nombre}}<br>
                @endif

                <b>Fecha de transacción: </b>{{$rst->payment_date}} <br>
                <b>Fecha de registro en el sistema: </b>{{$rst->created_at}} <br>
            </td>
            <td>
                @if($rst->status =="success")
                    <span class="badge badge-primary">{{$rst->status}}</span>
                @elseif($rst->status=="pending")
                    <span class="badge badge-warning">{{$rst->status}}</span>
                @elseif($rst->status=="failure")
                    <span class="badge badge-danger">{{$rst->status}}</span>
                @else
                    <span class="badge badge-danger">{{$rst->status}}</span>
                @endif
                @if($rst->refund =="SI")
                    <br><span class="badge badge-success">Reembolsado</span><br>
                    <b>Detalle: </b>{{$rst->detail_refund}}<br>
                    <b>fecha: </b>{{$rst->date_refund}}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>