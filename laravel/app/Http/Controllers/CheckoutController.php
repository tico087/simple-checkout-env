<?php

namespace App\Http\Controllers;


use App\Services\PaymentService;

use App\Http\Requests\CheckoutDataRequest;
use Illuminate\View\View;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use App\DataObjects\PaymentData;
use App\DataObjects\MockData\MockData;

class CheckoutController extends Controller
{

    public function __construct(protected PaymentService $service)
    {
    }

    public function index(): View
    {
        $products = MockData::mockProducts();
        return view('checkout.index', compact('products'));
    }



    public function process(CheckoutDataRequest $request): JsonResponse
    {

        try {
            $payment = $this->service->processTransaction($request);
            if ($payment['success']) {

                $payment = array_merge($payment ,['form_request' => $request->json()]);
                $data = PaymentData::fromRespose($payment);
                app(PaymentController::class)->processSuccessfulPayment($data);
            }
            return new JsonResponse($payment);

        } catch (\JsonException $e) {
            report($e);
            return new JsonResponse(['errors' => ['message' => 'Erro ao processar a Transação, Verifique os Dados inseridos ou entre em Contato com o nosso Suporte.']], 400);
        } catch (\Exception $e) {
            report($e);
            return new JsonResponse(['errors' => ['message' => 'Erro ao processar a Transação, Verifique os Dados inseridos ou entre em Contato com o nosso Suporte.']], 500);
        }
    }


    public function thanksPage(string $id): View
    {
        $payment = Payment::where('transaction_id', $id)->first();
        return view('checkout.thankspage', compact('payment'));
    }

}
