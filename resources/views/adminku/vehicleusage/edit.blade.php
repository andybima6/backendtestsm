@extends('layouts.welcome')

@section('content')
<main class="mx-auto p-36 contain-responsive bg-[#FBEEC1]">
    <div class="rounded-md relative p-16 bg-white">
        <p class="mb-6 text-3xl font-semibold text-center text-gray-800">Edit Penggunaan Kendaraan</p>
        <hr class="my-4">
        <form action="{{ route('adminku.vehicleusage.update', $usage->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-8">
                <label for="vehicle_id" class="block text-lg font-medium text-gray-700">Vehicle</label>
                <select name="vehicle_id" id="vehicle_id"
                    class="form-select mt-2 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <option value="">Select Vehicle</option>
                    @foreach ($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ $vehicle->id == $usage->vehicle_id ? 'selected' : '' }}>
                            {{ $vehicle->license_plate }} ({{ $vehicle->brand }} - {{ $vehicle->model }})
                        </option>
                    @endforeach
                </select>
                @error('vehicle_id')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-6">
                <label for="driver">Driver</label>
                <select name="driver" id="driver" class="form-control w-full" required>
                    <option value="">Select Driver</option>
                    @foreach ($reservations as $reservation)
                        <option value="{{ $reservation->id }}" {{ $reservation->id == $usage->driver ? 'selected' : '' }}>
                            {{ $reservation->user }}
                        </option>
                    @endforeach
                </select>
                @error('driver')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group mb-6">
                <label for="distance_travelled">Jarak Tempuh (km)</label>
                <input type="number" name="distance_travelled" id="distance_travelled" class="form-control w-full" value="{{ $usage->distance_travelled }}" required>
            </div>

            <div class="form-group mb-6">
                <label for="fuel_used">Bahan Bakar Terpakai (liter)</label>
                <input type="number" name="fuel_used" id="fuel_used" class="form-control w-full" value="{{ $usage->fuel_used }}" required>
            </div>

            <div class="form-group mb-6">
                <label for="usage_date">Tanggal Awal Penggunaan</label>
                <input type="date" name="usage_date" id="usage_date" class="form-control w-full" 
                    value="{{ \Carbon\Carbon::parse($usage->usage_date)->format('Y-m-d') }}" required>
            </div>
            
            <div class="form-group mb-6">
                <label for="end_date">Tanggal Akhir Penggunaan</label>
                <input type="date" name="end_date" id="end_date" class="form-control w-full" 
                    value="{{ \Carbon\Carbon::parse($usage->end_date)->format('Y-m-d') }}" required>
            </div>
            

            <button type="submit" class="btn btn-primary w-full">Update Penggunaan Kendaraan</button>
        </form>
    </div>
</main>
@endsection
