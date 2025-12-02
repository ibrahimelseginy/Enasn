<?php
namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        return Donation::with(['donor','project','campaign','warehouse','delegate','route'])->paginate(20);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'donor_id' => 'required|exists:donors,id',
            'type' => 'required|in:cash,in_kind',
            'cash_channel' => 'required_if:type,cash|in:cash,instapay,vodafone_cash',
            'amount' => 'nullable|numeric',
            'currency' => 'nullable|string',
            'receipt_number' => 'nullable|string|max:64',
            'estimated_value' => 'nullable|numeric',
            'project_id' => 'nullable|exists:projects,id',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'delegate_id' => 'nullable|exists:delegates,id',
            'route_id' => 'nullable|exists:travel_routes,id',
            'allocation_note' => 'nullable|string',
            'received_at' => 'nullable|date'
        ]);

        if ($data['type'] === 'cash') {
            if (!isset($data['amount'])) {
                return response()->json(['message' => 'amount is required for cash donations'], 422);
            }
            if (!isset($data['cash_channel'])) {
                $data['cash_channel'] = 'cash';
            }
            if (!isset($data['receipt_number']) || trim((string)$data['receipt_number'])==='') {
                return response()->json(['message' => 'receipt_number is required for cash donations'], 422);
            }
        } else {
            if (!isset($data['warehouse_id'])) {
                return response()->json(['message' => 'warehouse_id is required for in_kind donations'], 422);
            }
            if (!isset($data['estimated_value'])) {
                return response()->json(['message' => 'estimated_value is required for in_kind donations'], 422);
            }
        }

        $donation = Donation::create($data);
        \App\Services\DonationService::postCreate($donation);
        return $donation->load(['donor','project','campaign','warehouse','delegate','route']);
    }

    public function show(Donation $donation)
    {
        return $donation->load(['donor','project','campaign','warehouse','delegate','route']);
    }

    public function update(Request $request, Donation $donation)
    {
        $data = $request->validate([
            'type' => 'sometimes|in:cash,in_kind',
            'cash_channel' => 'nullable|in:cash,instapay,vodafone_cash',
            'amount' => 'nullable|numeric',
            'currency' => 'nullable|string',
            'receipt_number' => 'nullable|string|max:64',
            'estimated_value' => 'nullable|numeric',
            'project_id' => 'nullable|exists:projects,id',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'delegate_id' => 'nullable|exists:delegates,id',
            'route_id' => 'nullable|exists:travel_routes,id',
            'allocation_note' => 'nullable|string',
            'received_at' => 'nullable|date'
        ]);
        $donation->update($data);
        return $donation->load(['donor','project','campaign','warehouse','delegate','route']);
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return response()->noContent();
    }
}
