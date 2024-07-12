<?php

namespace App\Http\Requests;

use App\Rules\{Cellphone, Cpf};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutDataRequest extends FormRequest
{
    public function rules(): array
    {
        return [

            'info' => 'required|array',
            'info.email' => 'required|email',
            'info.firstName' => 'required|string',
            'info.lastName' => 'required|string',
            'info.phone' => ['required', new Cellphone()],
            'info.docNumber' => ['required', new Cpf()],
            'payment' => 'required|array',
            'payment.installments' => 'required|numeric',
            'payment.billingType' => [
                'required',
                Rule::in(['CREDIT_CARD', 'PIX', 'BOLETO']),
            ],
            'payment.holderName' => 'required_if:payment.billingType,CREDIT_CARD|string',
            'payment.number' => 'required_if:payment.billingType,CREDIT_CARD|string',
            'payment.expiryDate' => 'required_if:payment.billingType,CREDIT_CARD|date_format:m/Y',
            'payment.cvv' => 'required_if:payment.billingType,CREDIT_CARD|digits:3',
            'payment.total' => 'required|numeric',
            'address' => 'required|array',
            'address.number' => 'required|string',
            'address.zipcode' => 'required|string',
            'address.address' => 'required|string',
            'address.neighborhood' => 'required|string',
            'address.city' => 'required|string',
            'address.state' => 'required|string',
            'address.complement' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [

            'cart_id.string' => 'O ID do carrinho deve ser uma string.',
            'info.required' => 'As informações são obrigatórias.',
            'info.array' => 'As informações devem estar em um array.',
            'info.email.required' => 'O email é obrigatório.',
            'info.email.email' => 'O email deve ser um endereço de email válido.',
            'info.firstName.required' => 'O primeiro nome é obrigatório.',
            'info.firstName.string' => 'O primeiro nome deve ser uma string.',
            'info.lastName.required' => 'O sobrenome é obrigatório.',
            'info.phone.required' => 'O telefone é obrigatório.',
            'info.lastName.string' => 'O sobrenome deve ser uma string.',
            'info.docNumber.required' => 'O número do documento é obrigatório.',
            'payment.required' => 'As informações de pagamento são obrigatórias.',
            'payment.array' => 'As informações de pagamento devem estar em um array.',
            'payment.billingType.required' => 'O tipo de cobrança é obrigatório.',
            'payment.billingType.in' => 'O tipo de cobrança selecionado é inválido. Os valores permitidos são: CREDIT_CARD, PIX, BOLETO.',
            'payment.holderName.required_if' => 'O nome do titular é obrigatório quando o tipo de cobrança é CARTÃO DE CRÉDITO.',
            'payment.holderName.string' => 'O nome do titular deve ser uma string.',
            'payment.number.required_if' => 'O número do cartão é obrigatório quando o tipo de cobrança é CARTÃO DE CRÉDITO.',
            'payment.number.string' => 'O número do cartão deve ser uma string.',
            'payment.expiryDate.required_if' => 'A data de validade é obrigatória quando o tipo de cobrança é CARTÃO DE CRÉDITO.',
            'payment.expiryDate.date_format' => 'A data de validade deve estar no formato MM/AAAA.',
            'payment.cvv.required_if' => 'O CVV é obrigatório quando o tipo de cobrança é CARTÃO DE CRÉDITO.',
            'payment.cvv.digits' => 'O CVV deve ter 3 dígitos.',
            'address.required' => 'O endereço é obrigatório.',
            'address.array' => 'O endereço deve estar em um array.',
            'address.number.required' => 'O número do endereço é obrigatório.',
            'address.number.string' => 'O número do endereço deve ser uma string.',
            'address.zipcode.required' => 'O CEP é obrigatório.',
            'address.zipcode.string' => 'O CEP deve ser uma string.',
            'address.address.required' => 'O endereço é obrigatório.',
            'address.address.string' => 'O endereço deve ser uma string.',
            'address.neighborhood.required' => 'O bairro é obrigatório.',
            'address.neighborhood.string' => 'O bairro deve ser uma string.',
            'address.city.required' => 'A cidade é obrigatória.',
            'address.city.string' => 'A cidade deve ser uma string.',
            'address.state.required' => 'O estado é obrigatório.',
            'address.state.string' => 'O estado deve ser uma string.',
            'address.complement.string' => 'O complemento deve ser uma string.',
        ];
    }
}
