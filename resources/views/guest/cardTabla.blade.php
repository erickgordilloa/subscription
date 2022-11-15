<table id="tbl_cards" class="table table-bordered">
    <thead>
    <tr>
        <th>Tarjeta</th>
        <th>Estado</th>
        <th>Opción</th>
    </tr>
    </thead>
    <tbody>
        @foreach($results['cards'] as $rst)
            @if ($rst['status'] == 'valid')
                <tr>
                    <td>
                        {{$rst['bin']}}XXXXXX{{$rst['number']}}<br/>
                        {{$rst['expiry_month']}}/{{$rst['expiry_year']}}
                    </td>
                    <td>
                        válida
                        <label style="display: none">{{$rst['status']}}</label>
                    </td>
                    <td>
                        <button onclick="eliminar('{{$rst['token']}}','{{$rst['bin']}}XXXXXX{{$rst['number']}}')" type="button"
                            class="btn btn-danger btn_delete"><i class="fas fa-trash"></i> Eliminar</button>
                    
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>