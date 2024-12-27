@extends('layouts.welcome')

@section('content')
<main class="mx-auto p-36 contain-responsive bg-[#FBEEC1]">
    <div class="rounded-md relative p-16 bg-white">
        <p class="mb-6 text-3xl font-semibold text-center text-gray-800" style="font-family: 'Poppins', sans-serif;">Tambah Kendaraan</p>
        <hr class="my-4">

        <form action="{{ route('adminku.vehicles.store') }}" method="POST">
            @csrf
            <div class="form-group mb-6">
                <label for="vehicle_type" class="text-lg font-medium text-gray-700">Jenis Kendaraan</label>
                <select name="vehicle_type" id="vehicle_type" class="form-control border border-gray-300 rounded-md p-3 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <option value="passenger">Penumpang</option>
                    <option value="cargo">Kargo</option>
                </select>
            </div>

            <div class="form-group mb-6">
                <label for="license_plate" class="text-lg font-medium text-gray-700">Plat Nomor</label>
                <input type="text" name="license_plate" id="license_plate" class="form-control border border-gray-300 rounded-md p-3 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>

            <div class="form-group mb-6">
                <label for="brand" class="text-lg font-medium text-gray-700">Merk</label>
                <input type="text" name="brand" id="brand" class="form-control border border-gray-300 rounded-md p-3 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="form-group mb-6">
                <label for="model" class="text-lg font-medium text-gray-700">Model</label>
                <input type="text" name="model" id="model" class="form-control border border-gray-300 rounded-md p-3 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="form-group mb-6">
                <label for="last_service_date" class="text-lg font-medium text-gray-700">Tanggal Servis Terakhir</label>
                <input type="date" name="last_service_date" id="last_service_date" class="form-control border border-gray-300 rounded-md p-3 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <div class="form-group mb-6">
                <label for="next_service_date" class="text-lg font-medium text-gray-700">Tanggal Servis Berikutnya</label>
                <input type="date" name="next_service_date" id="next_service_date" class="form-control border border-gray-300 rounded-md p-3 w-full focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <button type="submit" class="btn btn-primary bg-indigo-600 text-white p-3 rounded-md w-full focus:outline-none hover:bg-indigo-700">
                Simpan Kendaraan
            </button>
        </form>
    </div>
</main>
@endsection
