<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    // Retrieve all bookings
    public function index()
    {
        $bookings = Booking::all();
        return response()->json($bookings);
    }

    // Store a new booking
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'branch_id' => 'required|integer',
            'car_id' => 'required|integer',
            'variant' => 'nullable|string|max:50',
            'pickupDate' => 'required|date',
            'returnDate' => 'required|date',
            'price' => 'required|numeric',
            'duration' => 'nullable|string|max:50',
            'pickupLocation' => 'nullable|string|max:255',
            'dropoffLocation' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $booking = Booking::create($request->all());

        return response()->json($booking, 201);
    }

    // Retrieve a specific booking
    public function show($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        return response()->json($booking);
    }

    // Update a specific booking
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'branch_id' => 'required|integer',
            'car_id' => 'required|integer',
            'variant' => 'nullable|string|max:50',
            'pickupDate' => 'required|date',
            'returnDate' => 'required|date',
            'price' => 'required|numeric',
            'duration' => 'nullable|string|max:50',
            'pickupLocation' => 'nullable|string|max:255',
            'dropoffLocation' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->update($request->all());

        return response()->json($booking);
    }

    // Delete a specific booking
    public function destroy($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }
}
