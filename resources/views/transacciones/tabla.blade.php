<table id="tbl_transacciones" class="table table-bordered">
    <thead>
    <tr>
        <th>Datos Personales</th>
        <th>Detalle de Transacción</th>
        <th>Monto</th>
        <th>Comentario</th>
        <th>Estado</th>
        <th>Opción</th>
    </tr>
    </thead>
    <tbody>
    @foreach($results as $rst)
        <tr>
            <td>{{$rst->user->name}}<br>
                <b>Correo: </b>{{ $rst->user->email }}
            </td>
            <td>
                <b>Código de Autorización: </b>{{$rst->authorization_code}}<br>
                <b>Id de la transacción: </b>{{$rst->id_response}} <br>
                @if ($rst->status == "success")
                    {{-- <b>Referencia: </b><a href="#" onclick="reference({{ $rst->id }},{{ $rst->subscription->id }})" data-toggle="modal" data-target=".modal-reference" >{{$rst->subscription->nombre}}  <i class="fas fa-edit"></i></a><br> --}}
                    <b>Referencia: </b>{{$rst->subscription->nombre}}  <br>
                @else
                    <b>Referencia: </b>{{$rst->subscription->nombre}}<br>
                @endif

                <b>Fecha de transacción: </b>{{$rst->payment_date}} <br>
                <b>Fecha de registro en el sistema: </b>{{$rst->created_at}} <br>
            </td>
             <td>
                ${{$rst->amount ? number_format($rst->amount, 2, '.', ',') : '0.00'}}
            </td>
            <td>
                {{$rst->comentario ?? ''}}
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
            <td>
                @if($rst->status =="success" and empty($rst->refund))
                 <button onclick="refund('{{ $rst->id_response }}','{{ $rst->subscription->nombre }}')" title="Reembolsar" type="button" class="btn btn-success btn-sm"><i class="fas fa-undo"></i> Reembolsar</button><br><br>
                 <button onclick="resend('{{ $rst->id }}','{{ $rst->subscription->nombre }}')" title="Reenviar" type="button" class="btn btn-primary btn-sm"><i class="fas fa-envelope"></i> Reenviar Correo</button>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
