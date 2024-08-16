<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
class BranchController extends Controller
{
    public function index()
    {
        return Branch::all();
    }

    public function show($id)
    {
        return Branch::findOrFail($id);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'phone' => 'required|string|max:255',
            'status' => 'nullable|in:pending,approved,suspended',
            'notes' => 'nullable|string',
            'opening_hours' => 'nullable|string',
            'services' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $branchData = $request->all();
        $branchData['opening_hours'] = json_decode($request->opening_hours, true);

        $branch = Branch::create($branchData);

        // Link the branch to the user
        $user = User::findOrFail($request->user_id);
        $user->branch_id = $branch->id;
        $user->is_renter = true;
        $user->save();

        return response()->json($branch, 201);
    }


    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);

        $request->validate([
            'name' => 'string|max:255',
            'address' => 'string|max:255',
            'city' => 'string|max:255',
            'state' => 'string|max:255',
            'zip_code' => 'string|max:255',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'opening_hours' => 'nullable|json',
            'services' => 'nullable|json',
            'user_id' => 'required|exists:users,id',

        ]);

        $branch->update($request->all());
        return response()->json($branch);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $branches = Branch::where('name', 'like', "%{$query}%")
            ->orWhere('city', 'like', "%{$query}%")
            ->get();

        return response()->json($branches);
    }

    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();
        return response()->noContent();
    }

    public function nearest(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $services = $request->input('services'); // Optional filter by services

        $query = Branch::selectRaw("
            id, name, address, latitude, longitude,
            ( 6371 * acos( cos( radians(?) ) *
            cos( radians( latitude ) )
            * cos( radians( longitude ) - radians(?) )
            + sin( radians(?) ) *
            sin( radians( latitude ) ) ) )
            AS distance", [$latitude, $longitude, $latitude])
            ->having('distance', '<', 50) // 50 km radius
            ->orderBy('distance');

        if ($services) {
            $query->whereJsonContains('services', $services);
        }

        $branches = $query->get();

        return response()->json($branches);
    }


    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        $branch = Branch::where('phone', $request->identifier)
                        ->orWhere('email', $request->identifier)
                        ->first();

        if (!$branch || !Hash::check($request->password, $branch->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Generate a token or session
        $token = $branch->createToken('BranchToken')->plainTextToken;

        return response()->json(['token' => $token, 'branch' => $branch]);
    }
}
