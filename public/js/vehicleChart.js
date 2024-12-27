document.addEventListener('DOMContentLoaded', function () {
    // Get the canvas element first
    const canvas = document.getElementById('vehicleChart');
    
    // Check if canvas exists
    if (!canvas) {
        console.error('Canvas element not found');
        return;
    }

    // Ensure labels and data are available and properly formatted
    try {
        const labels = JSON.parse(document.getElementById('vehicleChart').dataset.labels || '[]');
        const brandData = JSON.parse(document.getElementById('vehicleChart').dataset.brandData || '[]');
        const modelData = JSON.parse(document.getElementById('vehicleChart').dataset.modelData || '[]');

        // Log data for debugging
        console.log('Labels:', labels);
        console.log('Brand Data:', brandData);
        console.log('Model Data:', modelData);

        const ctx = canvas.getContext('2d');
        
        // Destroy existing chart if it exists
        if (window.vehicleChart instanceof Chart) {
            window.vehicleChart.destroy();
        }

        // Create new chart
        window.vehicleChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Data Brand',
                        data: brandData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Data Model',
                        data: modelData,
                        backgroundColor: 'rgba(255, 159, 64, 0.6)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                family: "'Poppins', sans-serif",
                                size: 14,
                            },
                            padding: 20
                        },
                    },
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                family: "'Poppins', sans-serif",
                                size: 12,
                            },
                            maxRotation: 45,
                            minRotation: 45
                        },
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [2, 4]
                        },
                        ticks: {
                            stepSize: 1,
                            precision: 0,
                            font: {
                                family: "'Poppins', sans-serif",
                                size: 12,
                            },
                        },
                    },
                },
            },
        });
    } catch (error) {
        console.error('Error creating chart:', error);
        alert('Terjadi kesalahan dalam memuat grafik.');
    }
});