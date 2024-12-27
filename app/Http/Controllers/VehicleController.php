<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VehicleExport;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{
    /**
     * Display a listing of the vehicles.
     *
     * @return \Illuminate\View\View
     */
    public function indexAdmin()
    {
        Log::info('Fetching all vehicles data for admin dashboard');

        $breadcrumb = (object) [
            'title' => 'Dashboard Vehicle',
            'subtitle' => 'Ringkasan data',
        ];
        $vehicles = Vehicle::all();

        Log::info('Fetched vehicles: ', ['count' => $vehicles->count()]);

        return view('adminku.vehicles.index', compact('vehicles', 'breadcrumb'));
    }

    /**
     * Show the form for creating a new vehicle.
     *
     * @return \Illuminate\View\View
     */
    public function createAdmin()
    {
        Log::info('Opening create vehicle form');

        $breadcrumb = (object) [
            'title' => 'Create Vehicle',
            'subtitle' => 'Ringkasan data',
        ];
        return view('adminku.vehicles.create', compact('breadcrumb'));
    }

    /**
     * Store a newly created vehicle in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAdmin(Request $request)
    {
        Log::info('Creating a new vehicle', ['data' => $request->all()]);

        $request->validate([
            'vehicle_type' => 'required|in:passenger,cargo',
            'license_plate' => 'required|unique:vehicles',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date',
        ]);

        $vehicle = Vehicle::create([
            'vehicle_type' => $request->vehicle_type,
            'license_plate' => $request->license_plate,
            'brand' => $request->brand,
            'model' => $request->model,
            'last_service_date' => $request->last_service_date,
            'next_service_date' => $request->next_service_date,
        ]);

        Log::info('Vehicle created successfully', ['vehicle' => $vehicle]);

        return redirect()->route('adminku.vehicles.index')->with('success', 'Vehicle added successfully');
    }

    /**
     * Show the form for editing the specified vehicle.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\View\View
     */
    public function editAdmin(Vehicle $vehicle)
    {
        Log::info('Opening edit form for vehicle', ['vehicle_id' => $vehicle->id]);

        $breadcrumb = (object) [
            'title' => 'Edit Vehicle',
            'subtitle' => 'Ringkasan data',
        ];
        return view('adminku.vehicles.edit', compact('breadcrumb', 'vehicle'));
    }

    /**
     * Update the specified vehicle in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAdmin(Request $request, Vehicle $vehicle)
    {
        Log::info('Updating vehicle', ['vehicle_id' => $vehicle->id, 'data' => $request->all()]);

        $request->validate([
            'vehicle_type' => 'required|in:passenger,cargo',
            'license_plate' => 'required|unique:vehicles,license_plate,' . $vehicle->id,
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date',
        ]);

        $vehicle->update([
            'vehicle_type' => $request->vehicle_type,
            'license_plate' => $request->license_plate,
            'brand' => $request->brand,
            'model' => $request->model,
            'last_service_date' => $request->last_service_date,
            'next_service_date' => $request->next_service_date,
        ]);

        Log::info('Vehicle updated successfully', ['vehicle_id' => $vehicle->id]);

        return redirect()->route('adminku.vehicles.index')->with('success', 'Vehicle updated successfully');
    }

    /**
     * Remove the specified vehicle from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyAdmin(Vehicle $vehicle)
    {
        Log::warning('Deleting vehicle', ['vehicle_id' => $vehicle->id]);

        $vehicle->delete();

        Log::info('Vehicle deleted successfully', ['vehicle_id' => $vehicle->id]);

        return redirect()->route('adminku.vehicles.index')->with('success', 'Vehicle deleted successfully');
    }

    /**
     * Export vehicle data to Excel.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportToExcel()
    {
        Log::info('Exporting vehicle data to Excel');

        return Excel::download(new VehicleExport, 'vehicles.xlsx');
    }

    /**
     * Display a listing of the vehicles for approval.
     *
     * @return \Illuminate\View\View
     */
    public function indexApproval()
    {
        Log::info('Fetching all vehicles data for approval dashboard');

        $breadcrumb = (object) [
            'title' => 'Dashboard Vehicle',
            'subtitle' => 'Ringkasan data',
        ];
        $vehicles = Vehicle::all();

        Log::info('Fetched vehicles for approval: ', ['count' => $vehicles->count()]);

        return view('Approval.vehicles.index', compact('vehicles', 'breadcrumb'));
    }

    /**
     * Remove the specified vehicle from storage for approval.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyApproval(Vehicle $vehicle)
    {
        Log::warning('Deleting vehicle for approval', ['vehicle_id' => $vehicle->id]);

        $vehicle->delete();

        Log::info('Vehicle for approval deleted successfully', ['vehicle_id' => $vehicle->id]);

        return redirect()->route('Approval.vehicles.index')->with('success', 'Vehicle deleted successfully');
    }

    /**
     * Show the form for editing the specified vehicle for approval.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\View\View
     */
    public function editApproval(Vehicle $vehicle)
    {
        Log::info('Opening edit form for vehicle for approval', ['vehicle_id' => $vehicle->id]);

        $breadcrumb = (object) [
            'title' => 'Edit Vehicle',
            'subtitle' => 'Ringkasan data',
        ];
        return view('Approval.vehicles.edit', compact('breadcrumb', 'vehicle'));
    }

    /**
     * Update the specified vehicle for approval.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateApproval(Request $request, Vehicle $vehicle)
    {
        Log::info('Updating vehicle for approval', ['vehicle_id' => $vehicle->id, 'data' => $request->all()]);

        $request->validate([
            'vehicle_type' => 'required|in:passenger,cargo',
            'license_plate' => 'required|unique:vehicles,license_plate,' . $vehicle->id,
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'nullable|date',
        ]);

        $vehicle->update([
            'vehicle_type' => $request->vehicle_type,
            'license_plate' => $request->license_plate,
            'brand' => $request->brand,
            'model' => $request->model,
            'last_service_date' => $request->last_service_date,
            'next_service_date' => $request->next_service_date,
        ]);

        Log::info('Vehicle for approval updated successfully', ['vehicle_id' => $vehicle->id]);

        return redirect()->route('Approval.vehicles.index')->with('success', 'Vehicle updated successfully');
    }
}
