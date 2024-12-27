@extends('layouts.welcome')

@section('content')
<main class="mx-auto p-36 contain-responsive bg-[#FBEEC1]">
    <div class="rounded-md relative p-16 bg-white">
        <p class="mb-10" style="font-size: 24px; font-family: 'Poppins', sans-serif; font-weight: 600; color: black;">Daftar Kendaraan:</p>
        <div class="mb-4 text-center">
            <a href="{{ route('Approval.vehicleusage.export') }}" class="btn btn-primary">
                <i class="fas fa-file-download"></i>
                Download Report
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-bordered w-full">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Vehicle</th>
                        <th class="border px-4 py-2">Driver</th>
                        <th class="border px-4 py-2">Distance</th>
                        <th class="border px-4 py-2">Fuel Used</th>
                        <th class="border px-4 py-2">Usage Date</th>
                        <th class="border px-4 py-2">End Date</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicleUsages as $usage)
                        <tr>
                            <td class="border px-4 py-2">{{ $usage->id }}</td>
                            <td class="border px-4 py-2 text-center">
                                {{ $usage->vehicle->license_plate }}
                                ({{ $usage->vehicle->brand }} - {{ $usage->vehicle->model }})
                            </td>
                            <td class="border px-4 py-2">
                                @if ($usage->reservation)
                                    {{ $usage->reservation->user }}
                                @else
                                    No Driver Assigned
                                @endif
                            </td>
                            
                            
                            <td class="border px-4 py-2">{{ $usage->distance_travelled }} km</td>
                            <td class="border px-4 py-2">{{ $usage->fuel_used }} liters</td>
                            <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($usage->usage_date)->format('Y-m-d') }}</td>
                            <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($usage->end_date)->format('Y-m-d') }}</td>
                            
                            <td class="border px-4 py-2">
                                <a href="{{ route('Approval.vehicleusage.edit', $usage->id) }}" class="btn btn-warning btn-sm px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection
