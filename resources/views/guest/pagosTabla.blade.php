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
                <b>Referencia: </b>{{$rst->subscription->nombre}}<br>
                <b>Fecha de registro: </b>{{$rst->created_at}} <br>
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