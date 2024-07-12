@extends('templates.default')
@php
    $billingType = data_get($payment->form_request, 'payment.billingType');
    $status = data_get($payment->api_response, 'status');

@endphp
@section('content')
    <div class="container">
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="{{ asset('/logo.png') }}" alt="" width="72" height="72">
            <h1>Obrigado !</h1>
            <p class="lead">
                Sua compra foi <strong>finalizada</strong><br>
                @if ($billingType === 'CREDIT_CARD')
                    @if ($status === 'CONFIRMED')
                        e o <strong>pagamento confirmado</strong>, agradecemos seu pedido.
                    @else
                        porém o pagamento não foi confirmado, clique em detalhes de pagamento para conclui-lo.
                    @endif
                    <br>
                    <small>
                        <a target="_blank" href="{{ data_get($payment->api_response, 'invoiceUrl') }}">Detalhes do
                            pagamento</a>
                    </small>
                @elseif ($billingType === 'BOLETO')
                    @if ($status === 'CONFIRMED')
                        e o <strong>pagamento confirmado</strong>, agradecemos seu pedido.
                    @else
                        porém o pagamento não foi confirmado, clique no link abaixo para acessar o boleto.
                    @endif
                    <br />
                    <small class="text-muted">
                        <a target="_blank" href="{{ data_get($payment->api_response, 'bankSlipUrl') }}">Visualizar o
                            boleto</a>
                    </small>
                @elseif ($billingType === 'PIX')
                    @if ($status === 'CONFIRMED')
                        e o <strong>pagamento confirmado</strong>, agradecemos seu pedido.
                    @else
                        porém o pagamento não foi confirmado, escaneie o QR code abaixo ou copie o código do pix para
                        efetuar pagamento.
                        <br />
                        <img class="my-4"
                            src="data:image/png;base64, {{ data_get($payment->api_response, 'qrCode.encodedImage') }}"
                            width="200" height="200" />
                        <br />
                        <small class="mt-4 text-muted">
                            <copy-link value="{{ data_get($payment->api_response, 'qrCode.payload') }}"></copy-link>
                        </small>
                    @endif
                @endif

            </p>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© {{ now()->year }} {{ config('app.name') }}</p>
        </footer>
    </div>
@endsection
