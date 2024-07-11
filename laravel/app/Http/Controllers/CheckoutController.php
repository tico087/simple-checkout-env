<?php

namespace App\Http\Controllers;


use App\Services\PaymentService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;
use App\Models\Order;
use App\DataObjects\PaymentData;
use Illuminate\Http\JsonResponse;

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


    public function process(PaymentData $data): JsonResponse
    {
        try {
            $payment = $this->service->processTransaction($data);
            return new JsonResponse($payment);
        } catch (\JsonException $e) {
            report($e);
            return new JsonResponse(['errors' => ['message' => 'Erro ao processar a Trasanção, Verifique os Dados inseridos ou entre em Contado com o nosso Suporte.']], 400);
        } catch (\Exception $e) {
            report($e);
            return new JsonResponse([
                'errors' => ['message' => 'Erro ao processar a Trasanção, Verifique os Dados inseridos ou entre em Contado com o nosso Suporte.']
            ], 500);
        }
    }

    public function thanksPage(int $orderId): View
    {
        $order = Order::findOrFail($orderId);
        return view('checkout.thanks', ["order" => $orderId]);
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
