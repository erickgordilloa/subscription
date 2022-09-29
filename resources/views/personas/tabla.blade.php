<table id="tbl_personas" class="table table-bordered">
    <thead>
    <tr>
        <th>Datos Personales</th>
        <th>Correo</th>
        <th>Dirección</th>
        <th>Celular</th>
    </tr>
    </thead>
    <tbody>
    @foreach($results as $rst)
        <tr>
            <td><a href="#"  data-toggle="modal" data-target=".modal-example" onclick="editar({{ $rst->id }},{{ $rst->tipo_identidad }},'{{ $rst->identidad }}','{{$rst->nombre}}','{{$rst->apellido}}','{{$rst->correo}}','{{$rst->direccion}}','{{$rst->celular}}')">{{$rst->nombre}} {{$rst->apellido}} <i class="fas fa-edit"></i></a>
                </br>
                <b>
                @if($rst->tipo_identidad =="1")
                    Cédula:
                @elseif($rst->tipo_identidad=="2")
                        Ruc:
                @elseif($rst->tipo_identidad=="3")
                      Pasaporte:
                @endif
                </b>
                {{$rst->identidad}}
            </td>
            <td>
                {{$rst->correo}}
            </td>
            <td>
                {{$rst->direccion}}
            </td>
            <td>
                {{$rst->celular}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
