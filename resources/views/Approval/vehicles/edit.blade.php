@extends('layouts.welcome')

@section('content')
<main class="mx-auto p-10 bg-[#FBEEC1] min-h-screen">
    <div class="max-w-4xl mx-auto p-8 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-800" style="font-family: 'Poppins', sans-serif;">
            Edit Kendaraan
        </h1>
        <hr class="mb-6 border-gray-300">

        <form action="{{ route('Approval.vehicles.update', $vehicle->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="vehicle_type" class="block text-sm font-medium text-gray-700">Jenis Kendaraan</label>
                    <select name="vehicle_type" id="vehicle_type" 
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="passenger" {{ $vehicle->vehicle_type == 'passenger' ? 'selected' : '' }}>Penumpang</option>
                        <option value="cargo" {{ $vehicle->vehicle_type == 'cargo' ? 'selected' : '' }}>Kargo</option>
                    </select>
                </div>

                <div>
                    <label for="license_plate" class="block text-sm font-medium text-gray-700">Plat Nomor</label>
                    <input type="text" name="license_plate" id="license_plate" 
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
                        value="{{ $vehicle->license_plate }}" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700">Merk</label>
                    <input type="text" name="brand" id="brand" 
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
                        value="{{ $vehicle->brand }}">
                </div>

                <div>
                    <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                    <input type="text" name="model" id="model" 
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
                        value="{{ $vehicle->model }}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="last_service_date" class="block text-sm font-medium text-gray-700">Tanggal Servis Terakhir</label>
                    <input type="date" name="last_service_date" id="last_service_date" 
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
                        value="{{ $vehicle->last_service_date ? \Carbon\Carbon::parse($vehicle->last_service_date)->format('Y-m-d') : '' }}">
                </div>

                <div>
                    <label for="next_service_date" class="block text-sm font-medium text-gray-700">Tanggal Servis Berikutnya</label>
                    <input type="date" name="next_service_date" id="next_service_date" 
                        class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" 
                        value="{{ $vehicle->next_service_date ? \Carbon\Carbon::parse($vehicle->next_service_date)->format('Y-m-d') : '' }}">
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg shadow-lg transition duration-200">
                    Update Kendaraan
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
