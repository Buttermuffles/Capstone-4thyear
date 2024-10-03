<?php

namespace App\Livewire;

use App\Models\Amenities;
use Livewire\Component;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\SubGuest; // Import the SubGuest model

class ViewBookingDetails extends Component
{
    public $ReservationId;
    public $reservation;
    public $Amenities;
    public $amenity_id;
    public $quantity;

    public $payment;

    // Properties for SubGuest
    public $subGuestFirstName;
    public $subGuestLastName;
    public $subGuestMiddleName;
    public $subGuestContactNumber;
    public $subGuestEmailAddress;
    public $subGuestBirthdate;
    public $subGuestGender;

    public function render()
    {
        return view('livewire.view-booking-details');
    }

    public function mount($ReservationId)
    {
        $this->ReservationId = $ReservationId;
        $this->reservation = Reservation::find($ReservationId);
        $this->Amenities = Amenities::all();
    }

    public function addPayment()
    {
        $this->validate([
            'payment' => 'required|numeric|min:1',
        ]);

        $remainingBalance = $this->reservation->TotalCost;

        foreach ($this->reservation->reservationAmenities as $amenity) {
            $remainingBalance += $amenity->TotalCost;
        }

        foreach ($this->reservation->payments as $payment) {
            $remainingBalance -= $payment->AmountPaid;
        }

        if ($this->payment > $remainingBalance) {
            session()->flash('message', 'Payment Exceeds Remaining Balance');
            $this->payment = '';
            return;
        }

        $this->reservation->payments()->create([
            'GuestId' => $this->reservation->GuestId,
            'AmountPaid' => $this->payment,
            'DateCreated' => now()->format('Y-m-d'),
            'TimeCreated' => now()->format('H:i:s'),
            'Status' => 'Confirmed',
            'PaymentType' => 'Cash',
            'ReferenceNumber' => $this->generateReferenceNumber(),
            'Purpose' => "Room Reservation",
        ]);

        session()->flash('message', 'Payment Complete');
    }

    public function confirmPayment($ref)
    {
        $payment = Payment::find($ref);
        $payment->Status = 'Confirmed';
        $payment->save();
        session()->flash('message', 'Payment Confirmed');
    }
    public function openAddSubGuestModal($reservationId)
    {
        $this->ReservationId = $reservationId; // Set the ReservationId
        $this->dispatchBrowserEvent('open-modal', ['modal' => 'add-modal-sub-guest']); // Use your modal opening logic
    }
    public function addSubGuest()
    {
        $this->validate([
            'subGuestFirstName' => 'required|string|max:255',
            'subGuestLastName' => 'required|string|max:255',
            'subGuestMiddleName' => 'nullable|string|max:255',
            'subGuestContactNumber' => 'nullable|string|max:15', // Adjust max length as necessary
            'subGuestEmailAddress' => 'nullable|email|max:255',
            'subGuestBirthdate' => 'nullable|date',
            'subGuestGender' => 'nullable|string|max:10', // You can adjust max length according to your needs
        ]);

        SubGuest::create([
            'ReservationId' => $this->ReservationId,
            'FirstName' => $this->subGuestFirstName,
            'LastName' => $this->subGuestLastName,
            'MiddleName' => $this->subGuestMiddleName,
            'ContactNumber' => $this->subGuestContactNumber,
            'EmailAddress' => $this->subGuestEmailAddress,
            'Birthdate' => $this->subGuestBirthdate,
            'Gender' => $this->subGuestGender,
        ]);

        session()->flash('message', 'Sub-Guest Added');

        // Reset the sub-guest fields after submission
        $this->reset(['subGuestFirstName', 'subGuestLastName', 'subGuestMiddleName', 'subGuestContactNumber', 'subGuestEmailAddress', 'subGuestBirthdate', 'subGuestGender']);
    }

    public function addAmenities()
    {
        $this->validate([
            'amenity_id' => 'required|exists:amenities,AmenitiesId',
            'quantity' => 'required|integer|min:1',
        ]);

        $totalCost = Amenities::find($this->amenity_id)->Price * $this->quantity;

        $this->reservation->reservationAmenities()->create([
            'AmenitiesId' => $this->amenity_id,
            'Quantity' => $this->quantity,
            'TotalCost' => $totalCost,
        ]);

        session()->flash('message', 'Amenity Added');

        // Optionally reset the fields after submission
        $this->reset(['amenity_id', 'quantity']);
    }

    public function checkIn()
    {
        if ($this->reservation->DateCheckIn > now()) {
            session()->flash('message', 'Guest Cannot be Checked In Yet');
            return;
        }

        if ($this->reservation->DateCheckOut < now()) {
            session()->flash('message', 'Guest Cannot be Checked In Anymore');
            return;
        }

        if ($this->reservation->Status == 'Checked Out') {
            session()->flash('message', 'Guest Already Checked Out');
            return;
        }

        if ($this->reservation->Status == 'Checked In') {
            session()->flash('message', 'Guest Already Checked In');
            return;
        }

        $this->reservation->Status = 'Checked In';
        $this->reservation->save();
        $this->reservation->checkInOuts()->create([
            'GuestId' => $this->reservation->GuestId,
            'DateCreated' => now(),
            'TimeCreated' => now(),
            'Type' => 'Checked In'
        ]);
        session()->flash('message', 'Guest Checked In');
    }

    public function checkOut()
    {
        $this->reservation->Status = 'Checked Out';
        $this->reservation->save();
        $this->reservation->checkInOuts()->create([
            'GuestId' => $this->reservation->GuestId,
            'DateCreated' => now(),
            'TimeCreated' => now(),
            'Type' => 'Checked Out'
        ]);

        session()->flash('message', 'Guest Checked Out');
    }

    public function generateReferenceNumber()
    {
        return 'REF-' . date('YmdHis');
    }
}
