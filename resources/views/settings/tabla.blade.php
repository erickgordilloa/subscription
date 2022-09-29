<table id="tbl_settings" class="table table-bordered">
    <thead>
    <tr>
        <th>Detalle Transferencia</th>
        <th>Detalle Ayuda</th>
        <th>Monto máximo</th>
        <th>Opción</th>
    </tr>
    </thead>
    <tbody>
    @foreach($results as $rst)
        <tr>
            <td>
                {!!$rst->text_transferencia!!}
            </td>
            <td>
                {!!$rst->text_ayuda!!}
            </td>
             <td>
                ${{$rst->max_monto ? number_format($rst->max_monto, 2, '.', ',') : '0.00'}}
            </td>
            <td>
                 <button onclick="editar({{ $rst->id }},'{{$rst->text_transferencia}}','{{$rst->text_ayuda}}','{{$rst->max_monto}}')" title="Editar" type="button" class="btn btn-success btn_show"><i class="fas fa-edit"></i> Editar</button>              
            </td>
        </tr>
    @endforeach
    </tbody>
</table>