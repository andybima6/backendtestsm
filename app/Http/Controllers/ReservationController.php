<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Reservation;
use App\Models\Vehicle;
use App\Models\User;
use App\Exports\ReservationExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Menampilkan daftar pemesanan kendaraan
     *
     * @return \Illuminate\View\View
     */
    public function indexAdmin()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard Reservation',
            'subtitle' => 'Ringkasan data',
        ];
        $user = Auth::user(); 
        $reservations = Reservation::with('user','vehicle', 'approverLevel1', 'approverLevel2')->get();
        return view('adminku.reservation.index', compact('user','reservations', 'breadcrumb'));
    }
    public function editAdmin($id)
    {
        // Menemukan pemesanan berdasarkan ID
        $reservation = Reservation::findOrFail($id);
        $vehicles = Vehicle::all();

        $breadcrumb = (object) [
            'title' => 'Edit Reservation',
            'subtitle' => 'Ubah pemesanan kendaraan',
        ];

        return view('adminku.reservation.edit', compact('reservation', 'vehicles', 'breadcrumb'));
    }
    public function updateAdmin(Request $request, $id)
{
    // Validasi input
    $validated = $request->validate([
        'vehicle_id' => 'required|exists:vehicles,id',
        'reservation_date' => 'required|date',
        'start_time' => 'required|date_format:Y-m-d\TH:i',
        'end_time' => 'required|date_format:Y-m-d\TH:i|after:start_time',
        'approved_status_level1' => 'nullable|in:pending,approved',
        'approved_status_level2' => 'nullable|in:pending,approved',
    ]);

    // Temukan pemesanan berdasarkan ID
    $reservation = Reservation::findOrFail($id);

    // Konversi format datetime-local ke format database (Y-m-d H:i:s)
    $reservation->vehicle_id = $request->vehicle_id;
    $reservation->reservation_date = $request->reservation_date;
    $reservation->start_time = \Carbon\Carbon::parse($request->start_time)->format('Y-m-d H:i:s');
    $reservation->end_time = \Carbon\Carbon::parse($request->end_time)->format('Y-m-d H:i:s');
    $reservation->approved_status_level1 = $request->approved_status_level1 ?? 'pending';
    $reservation->approved_status_level2 = $request->approved_status_level2 ?? 'pending';

    // Simpan perubahan
    $reservation->save();

    // Redirect ke halaman daftar dengan pesan sukses
    return redirect()->route('adminku.reservation.index')->with('success', 'Reservation successfully updated.');
}

    /**
     * Menampilkan halaman formulir pemesanan kendaraan
     *
     * @return \Illuminate\View\View
     */
    public function createAdmin()
    {

        $breadcrumb = (object) [
            'title' => 'Create Reservation',
            'subtitle' => 'Ringkasan data',
        ];
        $vehicles = Vehicle::all();

        return view('adminku.reservation.create', compact('vehicles', 'breadcrumb'));
    }

    /**
     * Menyimpan pemesanan kendaraan baru
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeadmin(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'user' => 'required|string|max:255',  
            'reservation_date' => 'required|date',
            'start_time' => 'required|date_format:Y-m-d\TH:i',
            'end_time' => 'required|date_format:Y-m-d\TH:i|after:start_time',
            'approved_status_level1' => 'nullable|in:pending,approved',
            'approved_status_level2' => 'nullable|in:pending,approved',
        ]);

        $start_time = (new \DateTime($request->start_time))->format('Y-m-d H:i:s');
        $end_time = (new \DateTime($request->end_time))->format('Y-m-d H:i:s');

        $reservation = new Reservation();
        $reservation->vehicle_id = $request->vehicle_id;
        $reservation->user = $request->user;  
        $reservation->reservation_date = $request->reservation_date;
        $reservation->start_time = $start_time;
        $reservation->end_time = $end_time;
        $reservation->approved_status_level1 = $request->approved_status_level1 ?? 'pending';
        $reservation->approved_status_level2 = $request->approved_status_level2 ?? 'pending';
        $reservation->save();

        return redirect()->route('adminku.reservation.index')->with('success', 'Reservation successfully created.');
    }

    public function exportReport(Request $request)
    {
        // Ambil tanggal mulai dan tanggal akhir dari inputan user
        $startDate = $request->start_date; // Tanggal mulai
        $endDate = $request->end_date; // Tanggal akhir

        // Validasi inputan tanggal
        if (!$startDate || !$endDate) {
            return back()->with('error', 'Silakan pilih rentang tanggal.');
        }

        // Mengekspor data dengan menggunakan ReservationExport
        return Excel::download(new ReservationExport($startDate, $endDate), 'reservations_report.xlsx');
    }
    public function approveLevel1Admin($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update([
            'approved_by_level1' => Auth::id(),
            'approved_status_level1' => 'approved',
        ]);

        return redirect()->route('adminku.reservation.index')->with('success', 'Reservation approved by Level 1');
    }

    /**
     * Menyetujui pemesanan kendaraan oleh level 2
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveLevel2Admin($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update([
            'approved_by_level2' => Auth::id(),
            'approved_status_level2' => 'approved',
        ]);

        return redirect()->route('adminku.reservation.index')->with('success', 'Reservation approved by Level 2');
    }

    /**
     * Menolak pemesanan kendaraan
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectAdmin($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update([
            'approved_status_level1' => 'rejected',
            'approved_status_level2' => 'rejected',
        ]);

        return redirect()->route('adminku.reservation.index')->with('success', 'Reservation rejected');
    }

    
    public function destroyAdmin($id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservation->delete();

        return redirect()->route('adminku.reservation.index')->with('success', 'Reservation successfully deleted.');
    }

    public function indexApproval()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard Reservation',
            'subtitle' => 'Ringkasan data',
        ];

        $reservations = Reservation::with('vehicle', 'approverLevel1', 'approverLevel2')->get();
        return view('Approval.reservation.index', compact('reservations', 'breadcrumb'));
    }

    public function approveLevel1Approval($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update([
            'approved_by_level1' => Auth::id(),
            'approved_status_level1' => 'approved',
        ]);

        return redirect()->route('Approval.reservation.index')->with('success', 'Reservation approved by Level 1');
    }

    /**
     * Menyetujui pemesanan kendaraan oleh level 2
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveLevel2Approval($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update([
            'approved_by_level2' => Auth::id(),
            'approved_status_level2' => 'approved',
        ]);

        return redirect()->route('Approval.reservation.index')->with('success', 'Reservation approved by Level 2');
    }

    public function rejectApproval($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update([
            'approved_status_level1' => 'rejected',
            'approved_status_level2' => 'rejected',
        ]);

        return redirect()->route('Approval.reservation.index')->with('success', 'Reservation rejected');
    }
}
