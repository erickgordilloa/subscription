<table id="tbl_personas" class="table table-bordered">
    <thead>
    <tr>
        <th>Datos Personales</th>
        <th>suscripción</th>
        <th>Tiempo</th>
        <th>Opciones</th>
    </tr>
    </thead>
    <tbody>
    @foreach($results as $rst)
        <tr>
            <td>
                {{$rst->user->name}}<br/>
                {{$rst->user->email}}
            </td>
            <td>
                {{$rst->subscription->nombre}}
            </td>
            <td>
                {{$rst->typeSubscription->name}}<br/>
                <b># suscripciones</b>: {{$rst->total_payment ?? 0}}<br/>
                <b># suscripciones pagadas</b>: {{$rst->number_payment ?? 0}}
            </td>
            <td>
                <button onclick="cobrar({{$rst->id}},'{{$rst->user->name}}')" data-id="{{$rst->id}}" data-name="{{$rst->nombre}}" type="button" class="btn btn-primary btn-sm"><i class="fa fa-credit-card" aria-hidden="true"></i> Cobrar</button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
