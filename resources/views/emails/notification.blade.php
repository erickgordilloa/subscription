@component('mail::message')

Hola {{$transaction->user->name}}, <br>Hemos recibido una transacción por motivo de {{$transaction->tipo->nombre}} <br>

# Detalle de la transacción
Id de la transacción: {{$transaction->id_response}} <br>
Número de Autorización: {{$transaction->authorization_code}} <br>
Monto: ${{$transaction->amount ? number_format($transaction->amount, 2, '.', ',') : '0.00'}}<br>

@if(!empty($transaction->tipo->texto))
# Indicaciones
{!! $transaction->tipo->texto !!}
@endif

Gracias,<br>
{{ config('app.name') }} | Alianza Samborondón
# Tu aporte nos ayuda a soñar y crecer.
@endcomponent
