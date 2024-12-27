@extends('layouts.welcome')

@section('content')
<main class="mx-auto px-12 py-24 contain-responsive">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <!-- Form untuk memilih rentang tanggal -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold mb-4 text-center">Pilih Rentang Tanggal untuk Laporan</h2>
            <form method="GET" action="{{ route('adminku.reservation.report') }}" class="flex flex-col sm:flex-row gap-4 items-center justify-center">
                <div class="flex flex-col">
                    <label for="start_date" class="font-medium">Tanggal Mulai</label>
                    <input type="date" name="start_date" required class="border border-gray-300 px-4 py-2 rounded-md">
                </div>

                <div class="flex flex-col">
                    <label for="end_date" class="font-medium">Tanggal Akhir</label>
                    <input type="date" name="end_date" required class="border border-gray-300 px-4 py-2 rounded-md">
                </div>

                <button type="submit" class="btn btn-primary mt-4 sm:mt-0 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow-md">
                    Download Report
                </button>
            </form>
        </div>

        <!-- Tombol Create -->
        <div class="mb-4 text-center">
            <a href="{{ route('adminku.reservation.create') }}" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md shadow-md">
                Create Reservation
            </a>
        </div>

        <!-- Tabel laporan pemesanan kendaraan -->
        <div class="overflow-x-auto mt-8">
            <table class="min-w-full table-auto bg-gray-50 rounded-lg">
                <thead>
                    <tr>
                        <th class="border px-4 py-3 text-center">ID</th>
                        <th class="border px-4 py-3 text-center">Vehicle</th>
                        <th class="border px-4 py-3 text-center">User</th>
                        <th class="border px-4 py-3 text-center">Reservation Date</th>
                        <th class="border px-4 py-3 text-center">Start Time</th>
                        <th class="border px-4 py-3 text-center">End Time</th>
                        <th class="border px-4 py-3 text-center">Status Admin</th>
                        <th class="border px-4 py-3 text-center">Status Approval</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $reservation)
                    <tr class="hover:bg-gray-100 transition-colors">
                        <td class="border px-4 py-3 text-center">{{ $reservation->id }}</td>
                        <td class="border px-4 py-3 text-center">{{ $reservation->vehicle->license_plate }}</td>
                        <td class="border px-4 py-3 text-center">{{ $reservation->user }}</td>
                        <td class="border px-4 py-3 text-center">{{ $reservation->reservation_date }}</td>
                        <td class="border px-4 py-3 text-center">{{ $reservation->start_time }}</td>
                        <td class="border px-4 py-3 text-center">{{ $reservation->end_time }}</td>
                        <td class="border px-4 py-3 text-center">{{ ucfirst($reservation->approved_status_level1) }}</td>
                        <td class="border px-4 py-3 text-center">{{ ucfirst($reservation->approved_status_level2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
