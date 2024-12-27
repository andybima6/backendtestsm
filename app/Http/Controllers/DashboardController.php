<?php

namespace App\Http\Controllers;

use App\Models\VehicleUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard for admin and approval views
     *
     * @param  Request $request
     * @param  string $viewName
     * @return \Illuminate\View\View
     */
    public function index(Request $request, $viewName = 'dashboardAdmin')
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard Admin',
            'subtitle' => 'Ringkasan data kendaraan',
        ];

        // Retrieve the vehicle usage data by brand and model
        $vehiclesByBrand = $this->getVehicleDataByBrand();
        $vehiclesByModel = $this->getVehicleDataByModel();

        // Debug log - Log both queries at once
        Log::info("Vehicle Dashboard Data Loaded", [
            'vehiclesByBrand' => $vehiclesByBrand->toArray(),
            'vehiclesByModel' => $vehiclesByModel->toArray(),
        ]);

        // Return the view with the data
        return view($viewName, compact('breadcrumb', 'vehiclesByBrand', 'vehiclesByModel'));
    }

    /**
     * Get vehicle data grouped by brand
     *
     * @return \Illuminate\Support\Collection
     */
    private function getVehicleDataByBrand()
    {
        // Check if the data is already cached, if not, fetch from database
        return Cache::remember('vehiclesByBrand', 60, function () {
            return VehicleUsage::select('vehicles.brand', DB::raw('COUNT(*) as total'))
                ->join('vehicles', 'vehicle_usages.vehicle_id', '=', 'vehicles.id')
                ->groupBy('vehicles.brand')
                ->orderBy('total', 'desc')
                ->get();
        });
    }

    /**
     * Get vehicle data grouped by model
     *
     * @return \Illuminate\Support\Collection
     */
    private function getVehicleDataByModel()
    {
        // Check if the data is already cached, if not, fetch from database
        return Cache::remember('vehiclesByModel', 60, function () {
            return VehicleUsage::select('vehicles.model', DB::raw('COUNT(*) as total'))
                ->join('vehicles', 'vehicle_usages.vehicle_id', '=', 'vehicles.id')
                ->groupBy('vehicles.model')
                ->orderBy('total', 'desc')
                ->get();
        });
    }

    /**
     * Display the dashboard for the admin view
     *
     * @param  Request $request
     * @return \Illuminate\View\View
     */
    public function indexAdmin(Request $request)
    {
        return $this->index($request, 'dashboardAdmin');
    }

    /**
     * Display the dashboard for the approval view
     *
     * @param  Request $request
     * @return \Illuminate\View\View
     */
    public function indexApproval(Request $request)
    {
        return $this->index($request, 'Approval.dashboardAdmin');
    }

}
