@extends('layouts.base')

@section('title', 'Checkout')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <!-- Informações do Cliente -->
            <div class="mb-3">
                <label for="customerName" class="form-label">Nome</label>
                <input type="text" class="form-control" id="customerName" name="name" required>
            </div>
            <div class="mb-3">
                <label for="customerEmail" class="form-label">Email</label>
                <input type="email" class="form-control" id="customerEmail" name="email" required>
            </div>
            <div class="mb-3">
                <label for="customerPhone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="customerPhone" name="phone" required>
            </div>


            <div class="mb-3">
                <label for="addressStreet" class="form-label">Rua</label>
                <input type="text" class="form-control" id="addressStreet" name="address_street" required>
            </div>
            <div class="mb-3">
                <label for="addressNumber" class="form-label">Número</label>
                <input type="text" class="form-control" id="addressNumber" name="address_number" required>
            </div>
            <div class="mb-3">
                <label for="addressComplement" class="form-label">Complemento</label>
                <input type="text" class="form-control" id="addressComplement" name="address_complement">
            </div>
            <div class="mb-3">
                <label for="addressNeighborhood" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="addressNeighborhood" name="address_neighborhood" required>
            </div>
            <div class="mb-3">
                <label for="addressCity" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="addressCity" name="address_city" required>
            </div>
            <div class="mb-3">
                <label for="addressState" class="form-label">Estado</label>
                <input type="text" class="form-control" id="addressState" name="address_state" required>
            </div>
            <div class="mb-3">
                <label for="addressPostalCode" class="form-label">CEP</label>
                <input type="text" class="form-control" id="addressPostalCode" name="address_postal_code" required>
            </div>


            <div class="mb-3">
                <label for="paymentMethod" class="form-label">Método de Pagamento</label>
                <select class="form-select" id="paymentMethod" name="payment_method" required>
                    <option value="boleto" selected>Boleto</option>
                    <option value="credit_card">Cartão de Crédito</option>
                    <option value="pix">Pix</option>
                </select>
            </div>


            <div id="creditCardFields" style="display: none;">
                <div class="mb-3">
                    <label for="cardNumber" class="form-label">Número do Cartão</label>
                    <input type="text" class="form-control" id="cardNumber" name="card_number" placeholder="1234 5678 9012 3456">
                </div>
                <div class="mb-3">
                    <label for="expirationDate" class="form-label">Data de Vencimento</label>
                    <input type="text" class="form-control" id="expirationDate" name="expiration_date" placeholder="MM/AA">
                </div>
                <div class="mb-3">
                    <label for="cvv" class="form-label">CVV</label>
                    <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Comprar</button>
        </form>
    </div>
</div>

@push('scripts')
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
@endpush
@endsection
