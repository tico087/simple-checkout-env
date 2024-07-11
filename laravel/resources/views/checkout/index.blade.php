@extends('templates.default')

@section('content')
    <div class="container">
        <div class="py-5 text-center">
            <h2>{{ config('app.name') }}</h2>
        </div>
        <checkout-form :products='@json($products)' submit_route="{{ route('checkout.process') }}"
            env={{ config('app.env') }}>
        </checkout-form>
        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© {{ now()->year }} {{ config('app.name') }}</p>
        </footer>
    </div>
@endsection
