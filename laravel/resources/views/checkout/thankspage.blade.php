@extends('templates.default')
@php

    $billingType = $payment->payment_method;
    $status = $payment->status;

@endphp
@section('content')
    <div class="container">
        <div class="py-5 text-center">

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
                        <a target="_blank" href="{{ $payment->invoice_url ?? null }}">Detalhes do
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
                        <a target="_blank" href="{{ $payment->bankslip_url ?? null}}">Visualizar o
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
                            src="data:image/png;base64, {{ $payment->qr_code['encodedImage']  ?? null }}"
                            width="200" height="200" />
                        <br />

                        <small class="mt-4 text-muted">
                            <copy-link value="{{  $payment->qr_code['payload'] }}"></copy-link>
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
