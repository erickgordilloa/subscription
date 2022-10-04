<table id="tbl_subscriptions" class="table table-bordered">
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Detalle</th>
        <th>Monto</th>
        <th>Opción</th>
    </tr>
    </thead>
    <tbody>
    @foreach($results as $rst)
        <tr>
            <td>
                {{$rst->nombre}} <br>
                <a href="{{$rst->imagen}}" target="_blank"></i> Ver foto</button>
            </td>
            <td>
                {{$rst->detalle}}
            </td>
             <td>
                ${{$rst->monto ? number_format($rst->monto, 2, '.', ',') : '0.00'}}
            </td>
            <td>
                 
                    <input type="hidden" name="texto_editable{{ $rst->id }}" id="texto_editable_{{ $rst->id }}" value="{{ $rst->texto }}">
                    <button onclick="editar({{ $rst->id }},'{{$rst->nombre}}','{{$rst->detalle}}','{{$rst->monto}}')" title="Editar" type="button" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Editar</button>
                    
                    <button onclick="eliminar({{$rst->id}},'{{$rst->nombre}}')" data-id="{{$rst->id}}" data-name="{{$rst->nombre}}" type="button"
                            class="btn btn-danger btn_delete btn-sm"><i class="fas fa-trash"></i> Eliminar</button>
              
            </td>
        </tr>
    @endforeach
    </tbody>
</table>