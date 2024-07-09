@extends('layouts.header')

@section('title', 'Checkout')

@include('layouts.content')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="customerName" class="form-label">Name</label>
                <input type="text" class="form-control" id="customerName" name="name" required>
            </div>
            <div class="mb-3">
                <label for="customerEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="customerEmail" name="email" required>
            </div>
            <div class="mb-3">
                <label for="customerPhone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="customerPhone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="paymentMethod" class="form-label">Payment Method</label>
                <select class="form-select" id="paymentMethod" name="payment_method" required>
                    <option value="credit_card">Credit Card</option>
                    <option value="boleto">Boleto</option>
                    <option value="pix">Pix</option>
                </select>
            </div>
            <div id="creditCardFields" style="display: none;">
                <div class="mb-3">
                    <label for="cardNumber" class="form-label">Card Number</label>
                    <input type="text" class="form-control" id="cardNumber" name="card_number">
                </div>
                <div class="mb-3">
                    <label for="expirationDate" class="form-label">Expiration Date</label>
                    <input type="text" class="form-control" id="expirationDate" name="expiration_date">
                </div>
                <div class="mb-3">
                    <label for="cvv" class="form-label">CVV</label>
                    <input type="text" class="form-control" id="cvv" name="cvv">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Finalize Payment</button>
        </form>
    </div>
</div>
<script>
    document.getElementById('paymentMethod').addEventListener('change', function () {
        var creditCardFields = document.getElementById('creditCardFields');
        if (this.value === 'credit_card') {
            creditCardFields.style.display = 'block';
        } else {
            creditCardFields.style.display = 'none';
        }
    });
</script>
@endsection

@include('layouts.footer')
