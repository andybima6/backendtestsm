@extends('layouts.welcome')
@section('content')
<main class="mx-auto p-36 contain-responsive bg-[#FBEEC1]">
    <div class="rounded-lg shadow-lg relative p-8 top-32 left-16 bg-white max-w-4xl mx-auto">
        <form action="{{ route('adminku.reservation.update', $reservation->id) }}" method="POST">
            @csrf
            @method('PUT')

            <h2 class="text-2xl font-semibold mb-6 text-center">Perbarui Pemesanan Kendaraan</h2>

            <div class="form-group mb-4">
                <label for="vehicle_id" class="block text-lg font-medium">Pilih Kendaraan</label>
                <input type="text" id="vehicle_id_display" 
                       class="form-control w-full p-3 border border-gray-300 rounded-md bg-gray-100 cursor-not-allowed" 
                       value="{{ $reservation->vehicle->license_plate }} ({{ $reservation->vehicle->brand }} - {{ $reservation->vehicle->model }})" readonly>
                <input type="hidden" name="vehicle_id" value="{{ $reservation->vehicle_id }}">
            </div>

            <div class="form-group mb-4">
                <label for="reservation_date" class="block text-lg font-medium">Tanggal Pemesanan</label>
                <input type="date" name="reservation_date" id="reservation_date" 
                       class="form-control w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                       value="{{ old('reservation_date', $reservation->reservation_date) }}" required>
            </div>

            <div class="form-group mb-4">
                <label for="start_time" class="block text-lg font-medium">Waktu Mulai</label>
                <input type="datetime-local" name="start_time" id="start_time" 
                       class="form-control w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                       value="{{ old('start_time', \Carbon\Carbon::parse($reservation->start_time)->format('Y-m-d\TH:i')) }}" required>
            </div>

            <div class="form-group mb-4">
                <label for="end_time" class="block text-lg font-medium">Waktu Selesai</label>
                <input type="datetime-local" name="end_time" id="end_time" 
                       class="form-control w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                       value="{{ old('end_time', \Carbon\Carbon::parse($reservation->end_time)->format('Y-m-d\TH:i')) }}" required>
            </div>

            <div class="flex justify-center mt-6">
                <button type="submit" class="btn btn-primary bg-indigo-500 text-white py-2 px-8 rounded-md hover:bg-indigo-600 transition duration-300">
                    Perbarui Pemesanan
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
