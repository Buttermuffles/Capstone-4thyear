@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold p-2">Dashboard</h1>

    <div class="bg-white p-4 rounded">
        <h2 class="font-bold">Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-2">
       
            <x-dashboard-card title="Today's Booking" count="{{ $totalBooking }}" /> <!-- Use for line chart -->
            <x-dashboard-card title="Today's Reservation" count="{{ $totalReservation }}" />
            <x-dashboard-card title="Number of Users" count="{{ $user }}" /> <!-- Update if necessary -->
        </div>
    </div>

    <!-- Combined Chart Section -->
    <div class="bg-white p-4 rounded shadow-md mt-4">
        <h2 class="font-bold text-md">Room Status and Check In/Out Chart</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-2"> <!-- Two columns layout -->
            <div>
                <canvas id="roomStatusChart" height="150"></canvas>
            </div>
            <div>
                <canvas id="checkInOutChart" height="150"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Room Status Chart
        const roomCtx = document.getElementById('roomStatusChart').getContext('2d');
        const roomStatusChart = new Chart(roomCtx, {
            type: 'bar',
            data: {
                labels: ['Available Rooms', 'Occupied Rooms'],
                datasets: [{
                    label: 'Room Status',
                    data: [{{ $availableRooms }}, {{ $occupiedRooms }}],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Check In and Check Out Chart
        const checkInOutCtx = document.getElementById('checkInOutChart').getContext('2d');
        const checkInOutChart = new Chart(checkInOutCtx, {
            type: 'line',
            data: {
                labels: ['Check In', 'Check Out'],
                datasets: [{
                    label: 'Today\'s Check In and Check Out',
                    data: [{{ $checkInCount }}, {{ $checkOutCount }}],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
     // Booking Chart (Line Chart)
     const bookingCtx = document.getElementById('bookingChart').getContext('2d');
        const bookingChart = new Chart(bookingCtx, {
            type: 'line',
            data: {
                labels: ['Today'], // X-axis label
                datasets: [{
                    label: 'Today\'s Booking',
                    data: [{{ $totalBooking }}], // Use today's booking count
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
