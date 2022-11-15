<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<link href="https://cdn.paymentez.com/ccapi/sdk/payment_stable.min.css" rel="stylesheet" type="text/css"/>
<script src="https://cdn.paymentez.com/ccapi/sdk/payment_stable.min.js" charset="UTF-8"></script>

<style>
  .panel {
    margin: 0 auto;
    background-color: #F5F5F7;
    border: 1px solid #ddd;
    padding: 20px;
    display: block;
    width: 80%;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
  }



  .btn:hover {
    cursor: pointer;
  }

  .payment-form .icon {
    position: absolute;
    display: block;
    width: 24px;
    height: 17px;
    left: 8px;
    top: 5px;
    pointer-events: none;
}
</style>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Agregar tarjeta </div>

                <div class="card-body">
                <form id="add-card-form">
                    <div class="payment-form" id="my-card" data-capture-name="true"></div>
                    <button class="btn btn-primary btn-block">Guardar</button>
                    <br/>
                    <div id="messages"></div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
        </main>
    </div>
</body>

<script>
  $(function () {

    //
    // EXAMPLE CODE FOR INTEGRATION
    // ---------------------------------------------------------------------------
    //
    //  1.) You need to import the JS file -> https://cdn.paymentez.com/ccapi/sdk/payment_stable.min.js
    //
    //  2.) You need to import the CSS file -> https://cdn.paymentez.com/ccapi/sdk/payment_stable.min.css
    //
    //  3.) Add the Payment Form
    //  <div class="payment-form" id="my-card" data-capture-name="true"></div>
    //
    //  3.) Init library
    //  Replace "PAYMENT_CLIENT_APP_CODE" and "PAYMENT_CLIENT_APP_KEY" with your own Client Credentials.
    //
    // 4.) Add Card: converts sensitive card data to a single-use token which you can safely pass to your server to charge the user.

    /**
     * Init library
     *
     * @param env_mode `prod`, `stg`, `local` to change environment. Default is `stg`
     * @param payment_client_app_code provided by Paymentez.
     * @param payment_client_app_key provided by Paymentez.
     */
    Payment.init('{{ env('ENV_MODE_PAYMENTEZ') }}', '{{ env('CLIENT_APP_CODE') }}', '{{ env('CLIENT_APP_KEY') }}');

    let form = $("#add-card-form");
    let submitButton = form.find("button");
    let submitInitialText = submitButton.text();

    $("#add-card-form").submit(function (e) {
      let myCard = $('#my-card');
      $('#messages').text("");
      let cardToSave = myCard.PaymentForm('card');
      if (cardToSave == null) {
        $('#messages').text("Invalid Card Data");
      } else {
        submitButton.attr("disabled", "disabled").text("Card Processing...");

        /*
        After passing all the validations cardToSave should have the following structure:

         let cardToSave = {
                            "card": {
                              "number": "5119159076977991",
                              "holder_name": "Martin Mucito",
                              "expiry_month": 9,
                              "expiry_year": 2020,
                              "cvc": "123",
                              "type": "vi"
                            }
                          };

        */


        let uid = "uid1234";
        let email = "jhon@doe.com";

        /* Add Card converts sensitive card data to a single-use token which you can safely pass to your server to charge the user.
         *
         * @param uid User identifier. This is the identifier you use inside your application; you will receive it in notifications.
         * @param email Email of the user initiating the purchase. Format: Valid e-mail format.
         * @param card the Card used to create this payment token
         * @param success_callback a callback to receive the token
         * @param failure_callback a callback to receive an error
         */
        Payment.addCard(uid, email, cardToSave, successHandler, errorHandler);

      }

      e.preventDefault();
    });


    let successHandler = function (cardResponse) {
      console.log(cardResponse.card);
      if (cardResponse.card.status === 'valid') {
        $('#messages').html('Card Successfully Added<br>' +
          'status: ' + cardResponse.card.status + '<br>' +
          "Card Token: " + cardResponse.card.token + "<br>" +
          "transaction_reference: " + cardResponse.card.transaction_reference
        );
      } else if (cardResponse.card.status === 'review') {
        $('#messages').html('Card Under Review<br>' +
          'status: ' + cardResponse.card.status + '<br>' +
          "Card Token: " + cardResponse.card.token + "<br>" +
          "transaction_reference: " + cardResponse.card.transaction_reference
        );
      } else {
        $('#messages').html('Error<br>' +
          'status: ' + cardResponse.card.status + '<br>' +
          "message Token: " + cardResponse.card.message + "<br>"
        );
      }
      submitButton.removeAttr("disabled");
      submitButton.text(submitInitialText);
    };

    let errorHandler = function (err) {
      console.log(err.error);
      $('#messages').html(err.error.type);
      submitButton.removeAttr("disabled");
      submitButton.text(submitInitialText);
    };

  });
</script>
</html>


