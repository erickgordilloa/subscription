<head>
	<title>{{ config('app.name', 'Suscripción') }}</title>
	<meta charset="utf-8">
	<meta name="author" content="Erick Gordillo Ayala.">
	<meta name="keyword" content="Software, Donaciones, Botón de pago, Alianza Samborondón, Iglesia">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css" integrity="sha384-VCmXjywReHh4PwowAiWNagnWcLhlEJLA5buUprzK8rxFgeH0kww/aWY76TfkUoSX" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="{{ asset('../css/styles.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('../font-awesome/css/font-awesome.min.css') }}">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
	<script src="https://cdn.paymentez.com/ccapi/sdk/payment_checkout_stable.min.js"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>