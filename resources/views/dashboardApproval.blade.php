@extends('layouts.welcome')

@section('content')
<!DOCTYPE html>
<html lang="en" class="BG-[#fbeec1]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-[#fbeec1]">

    <main class="mx-auto p-10 md:p-16 lg:p-24 bg-[#fbeec1]">
        <div class="rounded-lg shadow-lg bg-white p-8 md:p-12 lg:p-16">
            <div class="mb-8">
                <h1 class="text-2xl font-semibold text-gray-800">{{ $breadcrumb->title }}</h1>
                <p class="text-gray-600">{{ $breadcrumb->subtitle }}</p>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
                <div class="text-center mb-6">
                    <h2 class="text-xl font-semibold text-blue-500">Grafik Kendaraan Berdasarkan Brand dan Model</h2>
                </div>
                <div class="relative" style="height: 400px;">
                    <canvas id="vehicleChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Brand Summary</h3>
                    <div class="space-y-2">
                        @foreach ($vehiclesByBrand as $brand)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">{{ $brand->brand }}</span>
                                <span class="font-semibold">{{ $brand->total }} units</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Model Summary</h3>
                    <div class="space-y-2">
                        @foreach ($vehiclesByModel as $model)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">{{ $model->model }}</span>
                                <span class="font-semibold">{{ $model->total }} units</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const brands = @json($vehiclesByBrand->pluck('brand'));
            const brandCounts = @json($vehiclesByBrand->pluck('total'));
            const modelCounts = @json($vehiclesByModel->pluck('total'));

            const debugData = {
                brands: brands,
                brandCounts: brandCounts,
                modelCounts: modelCounts
            };

            const debugElement = document.getElementById('debugData');
            if (debugElement) {
                debugElement.textContent = JSON.stringify(debugData, null, 2);
            }

            const ctx = document.getElementById('vehicleChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: brands,
                    datasets: [{
                            label: 'Jumlah Brand',
                            data: brandCounts,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Jumlah Model',
                            data: modelCounts,
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            }
                        }
                    }
                }
            });
        });
    </script>

</body>
</html>
