<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use GuzzleHttp\Client;

class CarController extends Controller
{
    private $imgurClientId;

    public function __construct()
    {
        $this->imgurClientId = env('IMGUR_CLIENT_ID'); // Store your Imgur client ID in the .env file
    }

    public function store(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'branch_id' => 'required|integer|exists:branches,id',
            'title' => 'required|string|max:255',
            'images' => 'nullable|array',
            'engine' => 'nullable|string|max:255',
            'mileage' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'transmission' => 'required|string|max:255',
            'fuel_type' => 'nullable|string|max:255',
            'doors' => 'nullable|integer',
            'seats' => 'nullable|integer',
            'price_per_day' => 'nullable|numeric',
            'price_per_hour' => 'nullable|numeric',
            'price_per_month' => 'nullable|numeric',
            'additional_details' => 'nullable|string',
            'status' => 'required|string|in:available,rented,maintenance',
            'image_files.*' => 'mimes:jpg,jpeg,png,gif,webp|max:2048', // File validation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create car
        $car = Car::create($request->except('image_files'));

        // Handle file uploads
        $fileUrls = [];
        if ($request->hasFile('image_files')) {
            foreach ($request->file('image_files') as $file) {
                $fileContent = file_get_contents($file->getRealPath());

                $client = new Client();
                $response = $client->request('POST', 'https://api.imgur.com/3/image', [
                    'headers' => [
                        'Authorization' => 'Client-ID ' . $this->imgurClientId,
                    ],
                    'form_params' => [
                        'image' => base64_encode($fileContent),
                    ],
                ]);

                $responseBody = json_decode($response->getBody(), true);

                if ($responseBody['success']) {
                    $fileUrl = $responseBody['data']['link'];
                    CarImage::create([
                        'car_id' => $car->id,
                        'image_url' => $fileUrl,
                    ]);

                    $fileUrls[] = $fileUrl;
                } else {
                    Log::error('Imgur upload failed: ' . $responseBody['data']['error']);
                }
            }
        }

        return response()->json(['success' => true, 'car' => $car, 'images' => $fileUrls]);
    }

    public function search(Request $request)
    {
        // Retrieve branch IDs from query parameters
        $pickupBranch = $request->query('pickupBranch');
        $dropoffBranch = $request->query('dropoffBranch');

        // Ensure at least one branch ID is provided
        if (!$pickupBranch && !$dropoffBranch) {
            return response()->json(['error' => 'At least one branch ID (pickupBranch or dropoffBranch) is required'], 400);
        }

        // Initialize the query
        $carsQuery = Car::query();

        // Filter by pickupBranch if provided
        if ($pickupBranch) {
            $carsQuery->where('branch_id', $pickupBranch);
        }

        // Filter by dropoffBranch if provided
        if ($dropoffBranch) {
            $carsQuery->where('branch_id', $dropoffBranch);
        }

        // Fetch the cars based on the query
        $cars = $carsQuery->get();

        return response()->json($cars);
    }




    public function index(): JsonResponse
    {
        $cars = Car::with(['branch'])->get();
        return response()->json($cars);
    }

    public function show($id): JsonResponse
    {
        $car = Car::with(['branch'])->findOrFail($id);
        return response()->json($car);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $car = Car::findOrFail($id);

        $request->validate([
            'branch_id' => 'sometimes|exists:branches,id',
            'title' => 'sometimes|string|max:255',
            'engine' => 'sometimes|string|max:255',
            'mileage' => 'sometimes|string|max:255',
            'color' => 'sometimes|string|max:255',
            'transmission' => 'sometimes|string|max:255',
            'fuel_type' => 'sometimes|string|max:255',
            'doors' => 'sometimes|integer',
            'seats' => 'sometimes|integer',
            'price_per_day' => 'sometimes|numeric',
            'price_per_hour' => 'sometimes|numeric',
            'price_per_month' => 'sometimes|numeric',
            'additional_details' => 'sometimes|string',
            'status' => 'sometimes|string|in:available,rented,maintenance',
            'image_files.*' => 'sometimes|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $car->update($request->only([
            'branch_id', 'title', 'engine', 'mileage', 'color', 'transmission', 'fuel_type',
            'doors', 'seats', 'price_per_day', 'price_per_hour', 'price_per_month', 'additional_details', 'status'
        ]));

        if ($request->hasFile('image_files')) {
            foreach ($request->file('image_files') as $file) {
                if ($file->isValid()) {
                    // Upload the file to Imgur
                    $fileContent = file_get_contents($file->getRealPath());

                    $client = new \GuzzleHttp\Client();
                    $response = $client->request('POST', 'https://api.imgur.com/3/image', [
                        'headers' => [
                            'Authorization' => 'Client-ID ' . $this->imgurClientId,
                        ],
                        'form_params' => [
                            'image' => base64_encode($fileContent),
                        ],
                    ]);

                    $responseBody = json_decode($response->getBody(), true);

                    if ($responseBody['success']) {
                        $fileUrl = $responseBody['data']['link'];
                        CarImage::create([
                            'car_id' => $car->id,
                            'image_url' => $fileUrl,
                        ]);
                    } else {
                        Log::error('Imgur upload failed: ' . $responseBody['data']['error']);
                    }
                } else {
                    Log::error('File upload failed');
                }
            }
        }

        return response()->json($car);
    }

    public function destroy($id): JsonResponse
    {
        $car = Car::findOrFail($id);
        $car->delete();
        return response()->json(null, 204);
    }
}
