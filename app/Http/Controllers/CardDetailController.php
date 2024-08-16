<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CardDetail;
use App\Models\Booking;
use Carbon\Carbon;

class CardDetailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'card_number' => 'required|digits_between:8,19',
            'card_holder' => 'required|string',
            'expiry_date' => 'required|date_format:m/y',
            'issuer' => 'nullable|string',
            'cvv' => 'required|digits_between:3,4',
            'booking_id' => 'required|exists:booking,id', // Check against bookings table
        ]);

        // Validate card number and detect issuer
        $card_number = $request->card_number;
        if (!$this->isValidCardNumber($card_number)) {
            return response()->json(['message' => 'Invalid card number'], 400);
        }

        $issuer = $this->detectIssuer($card_number);

        // Create card detail with booking_id
        $cardDetail = CardDetail::create([
            'card_number' => $card_number,
            'card_holder' => $request->card_holder,
            'expiry_date' => Carbon::createFromFormat('m/y', $request->expiry_date)->format('Y-m-d'),
            'issuer' => $issuer,
            'cvv' => $request->cvv,
            'booking_id' => $request->booking_id,
        ]);

        return response()->json([
            'message' => 'Card details saved successfully!',
            'card_detail' => $cardDetail
        ], 201);
    }

    public function index()
    {
        $cardDetails = CardDetail::with('booking')->get(); // Eager load related booking
        return response()->json($cardDetails);
    }

    public function show($id)
    {
        $cardDetail = CardDetail::with('booking')->find($id);

        if (!$cardDetail) {
            return response()->json(['message' => 'Card detail not found'], 404);
        }

        return response()->json($cardDetail);
    }

    public function update(Request $request, $id)
    {
        $cardDetail = CardDetail::find($id);

        if (!$cardDetail) {
            return response()->json(['message' => 'Card detail not found'], 404);
        }

        $request->validate([
            'card_number' => 'sometimes|digits_between:8,19',
            'card_holder' => 'sometimes|string',
            'expiry_date' => 'sometimes|date_format:m/y',
            'issuer' => 'sometimes|string',
            'cvv' => 'sometimes|digits_between:3,4',
            'booking_id' => 'sometimes|exists:booking,id', // Ensure booking_id exists in bookings table
        ]);

        $data = $request->all();

        // Detect issuer if card number is provided
        if (isset($data['card_number'])) {
            if (!$this->isValidCardNumber($data['card_number'])) {
                return response()->json(['message' => 'Invalid card number'], 400);
            }
            $data['issuer'] = $this->detectIssuer($data['card_number']);
        }

        $cardDetail->update($data);

        return response()->json(['message' => 'Card detail updated successfully!', 'card_detail' => $cardDetail]);
    }

    public function destroy($id)
    {
        $cardDetail = CardDetail::find($id);

        if (!$cardDetail) {
            return response()->json(['message' => 'Card detail not found'], 404);
        }

        $cardDetail->delete();

        return response()->json(['message' => 'Card detail deleted successfully!']);
    }

    private function detectIssuer($card_number)
    {
        // Simple card type detection logic
        $card_number = preg_replace('/\D/', '', $card_number); // Remove non-digits

        $patterns = [
            'Visa' => '/^4/',
            'MasterCard' => '/^5[1-5]/',
            'American Express' => '/^3[47]/',
            'Discover' => '/^6/',
        ];

        foreach ($patterns as $issuer => $pattern) {
            if (preg_match($pattern, $card_number)) {
                return $issuer;
            }
        }

        return 'Unknown';
    }

    private function isValidCardNumber($card_number)
    {
        // Remove non-digits
        $card_number = preg_replace('/\D/', '', $card_number);

        // Validate card number using the Luhn algorithm
        $sum = 0;
        $length = strlen($card_number);
        $parity = $length % 2;

        for ($i = 0; $i < $length; $i++) {
            $digit = (int)$card_number[$i];

            if ($i % 2 == $parity) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
        }

        return $sum % 10 === 0;
    }
}
