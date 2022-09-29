<table id="tbl_subscriptions" class="table table-bordered">
    <thead>
    <tr>
        <th></th>
        <th>Nombre</th>
        <th>Detalle</th>
        <th>Monto</th>
        <th>El monto es editable</th>
        <th>Estado</th>
        <th>Opción</th>
    </tr>
    </thead>
    <tbody>
    @foreach($results as $rst)
        <tr>
            <td>
                <img onclick='abrir(this,{{ $rst->id }})' src='/images/details_open.png' style='cursor: pointer;'/>
            </td>
            <td>
                {{$rst->nombre}}
            </td>
            <td>
                {{$rst->detalle}}
            </td>
             <td>
                ${{$rst->monto ? number_format($rst->monto, 2, '.', ',') : '0.00'}}
            </td>
            <td>
                @if($rst->es_editable=='S')
                    <span class="badge badge-primary">SI</span>
                @else
                    <span class="badge badge-danger">NO</span>
                @endif
            </td>
            <td>
                @if($rst->estado=='A')
                    <span class="badge badge-primary">Activo</span>
                @else
                    <span class="badge badge-danger">Inactivo</span>
                @endif
            </td>
            <td>
                 
                    <input type="hidden" name="texto_editable{{ $rst->id }}" id="texto_editable_{{ $rst->id }}" value="{{ $rst->texto }}">
                    <button onclick="editar({{ $rst->id }},'{{$rst->nombre}}','{{$rst->detalle}}','{{$rst->monto}}','{{ $rst->estado }}','{{ $rst->es_editable }}')" title="Editar" type="button" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button>
                    <button onclick="document.getElementById('subscription_id').value = '{{$rst->id  }}'" title="Editar" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".modal-archivo"><i class="fas fa-file"></i> Archivos</button>
                   <!-- <button onclick="eliminar({{$rst->id}})" data-id="{{$rst->id}}" data-name="{{$rst->nombre}}" type="button"
                            class="btn btn-danger btn_delete"><i class="fas fa-trash"></i> Eliminar</button>-->
              
            </td>
        </tr>
    @endforeach
    </tbody>
</table>