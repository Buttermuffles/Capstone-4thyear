@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1 class="text-2xl font-bold p-2">Dashboard</h1>

    <div class="bg-white p-4 rounded">
        <h2 class="font-bold">Overview</h2>
    </div>

    <div class="bg-white p-4 rounded shadow-md mt-4">
        <h2 class="font-bold text-md">Room Status and Today's Booking Chart</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
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
        const roomCtx = document.getElementById('roomStatusChart').getContext('2d');
        const roomStatusChart = new Chart(roomCtx, {
            type: 'bar',
            data: {
                labels: ['Available Rooms', 'Occupied Rooms'],
                datasets: [{
                    label: 'Available',
                    data: [{{ $availableRooms }}, 0],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }, {
                    label: 'Occupied',
                    data: [0, {{ $occupiedRooms }}],
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
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

        const checkInOutCtx = document.getElementById('checkInOutChart').getContext('2d');
        const checkInOutChart = new Chart(checkInOutCtx, {
            type: 'line',
            data: { 
                labels:  ['Booking', 'Reservation', 'Check In', 'Check Out'],
                datasets: [
                    {
                        label: 'Booking',
                        data: [{{ $totalBooking }}, 0, 0, 0],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: true
                    },
                    {
                        label: 'Reservation',
                        data: [0, {{ $totalReservation }}, 0, 0],
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 2,
                        fill: true
                    },
                    {
                        label: 'Check In',
                        data: [0, 0, {{ $checkInCount }}, 0],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2,
                        fill: true
                    },
                    {
                        label: 'Check Out',
                        data: [0, 0, 0, {{ $checkOutCount }}],
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 2,
                        fill: true
                    }
                ]
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
