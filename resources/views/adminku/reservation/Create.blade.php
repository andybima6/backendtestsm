@extends('layouts.welcome')

@section('content')
<main class="mx-auto p-36 contain-responsive bg-[#FBEEC1]">
    <div class="rounded-md relative p-16 bg-white">
            <h2 class="mb-8 text-3xl font-semibold text-center text-black" style="font-family: 'Poppins', sans-serif;">
                Create New Reservation
            </h2>

            <form action="{{ route('adminku.reservation.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="vehicle_id" class="block text-lg font-medium text-gray-700">Vehicle</label>
                    <select name="vehicle_id" id="vehicle_id"
                        class="form-select mt-2 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                        <option value="">Select Vehicle</option>
                        @foreach ($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->license_plate }} ({{ $vehicle->brand }} -
                                {{ $vehicle->model }})</option>
                        @endforeach
                    </select>
                    @error('vehicle_id')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="user" class="block text-lg font-medium text-gray-700">User</label>
                    <input type="text" name="user" id="user"
                        class="form-input mt-2 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                    @error('user')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>



                <div class="mb-6">
                    <label for="reservation_date" class="block text-lg font-medium text-gray-700">Reservation Date</label>
                    <input type="date" name="reservation_date" id="reservation_date"
                        class="form-input mt-2 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                    @error('reservation_date')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="start_time" class="block text-lg font-medium text-gray-700">Start Time</label>
                    <input type="datetime-local" name="start_time" id="start_time"
                        class="form-input mt-2 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                    @error('start_time')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="end_time" class="block text-lg font-medium text-gray-700">end Time</label>
                    <input type="datetime-local" name="end_time" id="end_time"
                        class="form-input mt-2 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                    @error('end_time')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="approved_status_level1" class="block text-lg font-medium text-gray-700">Approval
                        Admin</label>
                    <select name="approved_status_level1" id="approved_status_level1"
                        class="form-select mt-2 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        @if (auth()->user()->role_id != 1) disabled @endif>
                        <option value="pending" @if (old('approved_status_level1', 'pending') == 'pending') selected @endif>Pending</option>
                        <option value="approved" @if (old('approved_status_level1') == 'approved') selected @endif>Approved</option>
                    </select>
                    @error('approved_status_level1')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="approved_status_level2" class="block text-lg font-medium text-gray-700">Approval
                        Approval</label>
                    <select name="approved_status_level2" id="approved_status_level2"
                        class="form-select mt-2 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        @if (auth()->user()->role_id != 2) disabled @endif>
                        <option value="pending" @if (old('approved_status_level2', 'pending') == 'pending') selected @endif>Pending</option>
                        <option value="approved" @if (old('approved_status_level2') == 'approved') selected @endif>Approved</option>
                    </select>
                    @error('approved_status_level2')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-center">
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white text-lg rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                        Create Reservation
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
