@extends('layouts.welcome')

@section('content')
<main class="mx-auto p-36 contain-responsive bg-[#FBEEC1]">
    <div class="rounded-md relative p-16 bg-white">
        <p class="mb-10" style="font-size: 24px; font-family: 'Poppins', sans-serif; font-weight: 600; color: black;">Daftar Kendaraan:</p>
        <a href="{{ route('adminku.vehicles.create') }}" class="btn btn-primary mb-4">Tambah Kendaraan</a>
        <div class="mb-4 text-center">
            <a href="{{ route('Approval.vehicles.export') }}" class="btn btn-primary">
                <i class="fas fa-file-download"></i>
                Download Report
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="border px-4 py-2 text-center">ID</th>
                        <th class="border px-4 py-2 text-center">Type</th>
                        <th class="border px-4 py-2 text-center">License Plate</th>
                        <th class="border px-4 py-2 text-center">Brand</th>
                        <th class="border px-4 py-2 text-center">Model</th>
                        <th class="border px-4 py-2 text-center">Last Service Date</th>
                        <th class="border px-4 py-2 text-center">Next Service Date</th>
                        <th class="border px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $vehicle->id }}</td>
                        <td class="border px-4 py-2 text-center">{{ ucfirst($vehicle->vehicle_type) }}</td>
                        <td class="border px-4 py-2 text-center">{{ $vehicle->license_plate }}</td>
                        <td class="border px-4 py-2 text-center">{{ $vehicle->brand }}</td>
                        <td class="border px-4 py-2 text-center">{{ $vehicle->model }}</td>
                        <td class="border px-4 py-2 text-center">
                            {{ $vehicle->last_service_date ? \Carbon\Carbon::parse($vehicle->last_service_date)->format('Y-m-d') : '-' }}
                        </td>
                        <td class="border px-4 py-2 text-center">
                            {{ $vehicle->next_service_date ? \Carbon\Carbon::parse($vehicle->next_service_date)->format('Y-m-d') : '-' }}
                        </td>
                        
                        <td class="border px-4 py-2 text-center">
                            <a href="{{ route('Approval.vehicles.edit', $vehicle->id) }}" class="btn btn-warning btn-sm px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
