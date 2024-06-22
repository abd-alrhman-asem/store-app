<?php

namespace App\Http\Controllers;

use App\Http\Requests\orders\CreateOrderRequest;
use App\Http\Requests\orders\UpdateOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function __construct( public OrderService $orderService)
    {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->status;
        $orders = $this->orderService->getAllOrders($status);

        return success($orders);
    }

    /**
     * @param CreateOrderRequest $request
     * @return JsonResponse
     */
    public function store(CreateOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->createOrder($request);

        return successOperationResponse('Order saved successfully', $order);
    }

    /**
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return JsonResponse
     * @throws \Exception
     */
    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        $order = $this->orderService->updateOrder($request, $order);
        return successOperationResponse('Order updated successfully', $order);
    }

    /**
     * @param Order $order
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Order $order): JsonResponse
    {
        $this->orderService->deleteOrder($order);

        return successOperationResponse('Order deleted successfully');
    }
}
