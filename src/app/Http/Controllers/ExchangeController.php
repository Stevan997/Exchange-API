<?php

namespace App\Http\Controllers;

use App\Services\ExchangeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    private ExchangeService $service;

    /**
     * @param ExchangeService $service
     */
    public function __construct(ExchangeService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function exchange(Request $request): JsonResponse
    {
        return response()->json($this->service->exchange($request));
    }
}
