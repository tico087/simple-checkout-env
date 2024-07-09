@extends('layouts.header')

@section('title', 'Thank You')

@include('layouts.content')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2 text-center">
        <h1>Thank You for Your Payment!</h1>
        @if ($payment->payment_method === 'credit_card')
            <p>Your payment was processed successfully.</p>
        @elseif ($payment->payment_method === 'boleto')
            <p>Please use the following link to download your boleto:</p>
            <a href="{{ $payment->payment_link }}" class="btn btn-primary">Download Boleto</a>
        @elseif ($payment->payment_method === 'pix')
            <p>Please scan the QR Code or use the "Copy and Paste" code below to complete your payment:</p>
            <img src="{{ $payment->qr_code }}" alt="QR Code">
            <p>{{ $payment->copia_e_cola }}</p>
        @endif
    </div>
</div>
@endsection

@include('layouts.footer')
