<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleUsage;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VehicleUsageExport;
use Illuminate\Support\Facades\Log;  // Add the log facade

class VehicleUsageController extends Controller
{
    /**
     * Menampilkan semua riwayat penggunaan kendaraan.
     *
     * @return \Illuminate\View\View
     */
    public function indexAdmin()
    {
        $breadcrumb = (object)[
            'title' => 'Dashboard usage',
            'subtitle' => 'Ringkasan data',
        ];
        $vehicleUsages = VehicleUsage::with('reservation.user')->get();

        // Log: Retrieve all vehicle usage records
        Log::info('Admin accessed vehicle usage dashboard', [
            'vehicleUsagesCount' => $vehicleUsages->count()
        ]);

        return view('adminku.vehicleusage.index', compact('vehicleUsages','breadcrumb'));
    }

    /**
     * Menampilkan formulir untuk menambahkan riwayat penggunaan kendaraan.
     *
     * @return \Illuminate\View\View
     */
    public function createAdmin()
    {
        $breadcrumb = (object)[
            'title' => 'Create usage',
            'subtitle' => 'Ringkasan data',
        ];
        $vehicles = Vehicle::all();
        $reservations = Reservation::all();

        // Log: Display create usage form
        Log::info('Admin accessed vehicle usage create form.');

        return view('adminku.vehicleusage.create', compact('vehicles','reservations','breadcrumb'));
    }

    /**
     * Menyimpan riwayat penggunaan kendaraan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAdmin(Request $request)
    {
        $this->validateVehicleUsage($request);

        $usage = VehicleUsage::create([
            'vehicle_id' => $request->vehicle_id,
            'driver' => $request->driver,
            'distance_travelled' => $request->distance_travelled,
            'fuel_used' => $request->fuel_used,
            'usage_date' => $request->usage_date,
            'end_date' => $request->end_date,
        ]);

        // Log: Vehicle usage stored
        Log::info('Admin stored new vehicle usage record', [
            'vehicle_id' => $request->vehicle_id,
            'driver' => $request->driver,
            'distance_travelled' => $request->distance_travelled,
        ]);

        return redirect()->route('adminku.vehicleusage.index')->with('success', 'Vehicle usage recorded successfully.');
    }

    /**
     * Menampilkan formulir untuk mengedit riwayat penggunaan kendaraan.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function editAdmin($id)
    {
        $breadcrumb = (object)[
            'title' => 'Edit usage',
            'subtitle' => 'Ringkasan data',
        ];
        $usage = VehicleUsage::findOrFail($id);
        $reservations = Reservation::all();
        $vehicles = Vehicle::all();

        // Log: Accessing edit vehicle usage form
        Log::info('Admin accessed vehicle usage edit form', [
            'usage_id' => $id
        ]);

        return view('adminku.vehicleusage.edit', compact('vehicles','usage', 'reservations', 'breadcrumb'));
    }

    /**
     * Memperbarui riwayat penggunaan kendaraan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAdmin(Request $request, $id)
    {
        $this->validateVehicleUsage($request);

        $usage = VehicleUsage::findOrFail($id);
        $usage->update([
            'vehicle_id' => $request->vehicle_id,
            'driver' => $request->driver,
            'distance_travelled' => $request->distance_travelled,
            'fuel_used' => $request->fuel_used,
            'usage_date' => $request->usage_date,
            'end_date' => $request->end_date,
        ]);

        // Log: Vehicle usage updated
        Log::info('Admin updated vehicle usage record', [
            'usage_id' => $id,
            'vehicle_id' => $request->vehicle_id,
            'driver' => $request->driver,
        ]);

        return redirect()->route('adminku.vehicleusage.index')->with('success', 'Vehicle usage updated successfully.');
    }

    /**
     * Menghapus riwayat penggunaan kendaraan.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyAdmin($id)
    {
        $usage = VehicleUsage::findOrFail($id);
        $usage->delete();

        // Log: Vehicle usage deleted
        Log::info('Admin deleted vehicle usage record', [
            'usage_id' => $id
        ]);

        return redirect()->route('adminku.vehicleusage.index')->with('success', 'Vehicle usage deleted successfully.');
    }

    public function editApproval($id)
    {
        $breadcrumb = (object)[
            'title' => 'Edit usage',
            'subtitle' => 'Ringkasan data',
        ];
        $vehicles = Vehicle::all();
        $usage = VehicleUsage::findOrFail($id);
        $reservations = Reservation::all();

        // Log: Accessing approval edit form
        Log::info('Approval user accessed vehicle usage edit form', [
            'usage_id' => $id
        ]);

        return view('Approval.vehicleusage.edit', compact('vehicles','usage', 'reservations', 'breadcrumb'));
    }

    public function indexApproval()
    {
        $breadcrumb = (object)[
            'title' => 'Dashboard usage',
            'subtitle' => 'Ringkasan data',
        ];
        $vehicleUsages = VehicleUsage::with(['vehicle', 'reservation'])->get();

        // Log: Approval user accessed vehicle usage dashboard
        Log::info('Approval user accessed vehicle usage dashboard', [
            'vehicleUsagesCount' => $vehicleUsages->count()
        ]);

        return view('Approval.vehicleusage.index', compact('vehicleUsages','breadcrumb'));
    }

    public function updateApproval(Request $request, $id)
    {
        $this->validateVehicleUsage($request);

        $usage = VehicleUsage::findOrFail($id);
        $usage->update([
            'vehicle_id' => $request->vehicle_id,
            'driver' => $request->driver,
            'distance_travelled' => $request->distance_travelled,
            'fuel_used' => $request->fuel_used,
            'usage_date' => $request->usage_date,
            'end_date' => $request->end_date,
        ]);

        // Log: Vehicle usage updated for approval
        Log::info('Approval user updated vehicle usage record', [
            'usage_id' => $id,
            'vehicle_id' => $request->vehicle_id,
            'driver' => $request->driver,
        ]);

        return redirect()->route('Approval.vehicleusage.index')->with('success', 'Vehicle usage updated successfully.');
    }

    public function exportAdmin()
    {
        // Log: Exporting vehicle usage data
        Log::info('Admin exporting vehicle usage data.');

        return Excel::download(new VehicleUsageExport, 'vehicle_usages.xlsx');
    }

    /**
     * Validate vehicle usage input data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    private function validateVehicleUsage(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver' => 'required|exists:reservations,id',
            'distance_travelled' => 'required|numeric',
            'fuel_used' => 'required|numeric',
            'usage_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
    }
}
