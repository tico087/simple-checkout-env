<?php

namespace App\Http\Controllers;


use App\Services\PaymentService;

use App\Http\Requests\CheckoutDataRequest;
use Illuminate\View\View;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use App\DataObjects\PaymentData;

class CheckoutController extends Controller
{

    public function __construct(protected PaymentService $service)
    {
    }

    public function index(): View
    {
        $products = $this->mockProducts();
        return view('checkout.index', compact('products'));
    }



    public function process(CheckoutDataRequest $request): JsonResponse
    {
        try {
            $payment = $this->service->processTransaction($request);
            if($payment['success'])
            {
                // dd($payment);
                $data = PaymentData::fromArray($payment);
                app(PaymentController::class)->processSuccessfulPayment($data);
                return new JsonResponse($payment);
            }

        } catch (\JsonException $e) {
            report($e);
            return new JsonResponse(['errors' => ['message' => 'Erro ao processar a Transação, Verifique os Dados inseridos ou entre em Contato com o nosso Suporte.']], 400);
        } catch (\Exception $e) {
            report($e);
            return new JsonResponse(['errors' => ['message' => 'Erro ao processar a Transação, Verifique os Dados inseridos ou entre em Contato com o nosso Suporte.']], 500);
        }
    }


    public function thanksPage(int $orderId): View
    {
        $order = Order::findOrFail($orderId);
        return view('checkout.thankspage', ["order" => $orderId]);
    }

    public function mockProducts(): array
    {
        return [
            'items' => [
                ['name' => 'Aspirador', 'price' => 237.90, 'id' => 456],
                ['name' => 'Tapete Médio', 'price' => 180.27, 'id' => 841],
            ]
        ];
    }
}
