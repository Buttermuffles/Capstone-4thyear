<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Report;
use App\Models\Guest;  // Add the Guest model
use Illuminate\Support\Carbon;

class ReportTable extends Component
{ 
    
    public $guest_id;
    public $type;
    public $startdate;
    public $enddate;
    public $isEndDateDisabled = false;
    public $search = '';

    public function render()
    {
        // Retrieve guests for the dropdown
        $guests = Guest::all();

        // Retrieve reports based on the search query and order by created date
        return view('livewire.report-table', [
            'reports' => Report::search($this->search)->orderBy('CreatedAt', 'desc')->get(),
            'guests' => $guests // Pass the guests to the view
        ]);
    }

    public function createReport()
{
    // Validation rules depending on the report type
    if ($this->type === 'Guest History Report') {
        $this->validate([
            'type' => 'required|string',
            'guest_id' => 'required|integer', // Ensure guest_id is validated
        ]);

        // Set Date and EndDate to the current date
        $date = now();  // Current date
        $endDate = now(); // Current date

    } elseif ($this->type === 'Daily Revenue Report') {
        $this->validate([
            'type' => 'required|string',
            'startdate' => 'required|date|before_or_equal:today',
        ]);

        // Set Date to startdate and EndDate to null
        $date = $this->startdate;
        $endDate = null;

    } else {
        $this->validate([
            'type' => 'required|string',
            'startdate' => 'required|date|before_or_equal:today',
            'enddate' => 'required|date|before_or_equal:today',
        ]);

        // For other reports, set Date to startdate and EndDate to the specified enddate
        $date = $this->startdate;
        $endDate = $this->enddate;
    }

    $employeeId = auth()->id(); // Get the authenticated employee ID
    $report = new Report();

    // Generate a report name based on type and timestamp
    $report->ReportName = $this->type . "-" . now()->timestamp;

    $report->type = $this->type;
    $report->EmployeeId = $employeeId;
    $report->Date = $date; // Set Date based on report type
    $report->EndDate = $endDate; // Set EndDate based on report type

    // Set the created date and save the report
    $report->CreatedAt = now();
    $report->save();
}

    
    
    public function disableField()
    {
        // Check if the report type contains 'Revenue Report' and disable the end date field accordingly
        $this->isEndDateDisabled = str_contains($this->type, 'Revenue Report');
    }
}
