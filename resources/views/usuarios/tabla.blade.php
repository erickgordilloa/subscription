<table id="tbl_usuarios" class="table table-bordered">
    <thead>
    <tr>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Opción</th>
    </tr>
    </thead>
    <tbody>
    @foreach($results as $rst)
        <tr>
            <td>
                {{$rst->name}}
            </td>
            <td>
                {{$rst->email}}
            </td>
            <td>
                <button onclick="editar({{ $rst->id }},'{{ $rst->name }}','{{ $rst->email }}')" title="Editar" type="button" class="btn btn-success btn_show"><i class="fas fa-edit"></i> Editar</button>
                <button onclick="eliminar({{$rst->id}},'{{ $rst->name }}')" data-id="{{$rst->id}}" data-name="{{$rst->nombre}}" type="button" class="btn btn-danger btn_delete"><i class="fas fa-trash"></i> Eliminar</button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>