<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    private $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function webhook(Request $request)
    {
        try {
            // Log incoming request for debugging
            Log::info('WhatsApp webhook received', $request->all());

            $result = $this->whatsAppService->processIncomingMessage($request->all());

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('WhatsApp webhook error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error'
            ], 500);
        }
    }
}
