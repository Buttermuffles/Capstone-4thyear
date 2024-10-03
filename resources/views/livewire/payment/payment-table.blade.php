<div class="bg-gray-50 rounded">

    <div class="fle justify-normal w-1/2">
        <h5 class="mx-2 font-bold px-2 pt-2">Search</h5>
        <div class="flex items-center space-x-4"> <!-- Added space-x-4 for horizontal spacing -->

            <div class="relative mb-4 w-full mx-3 flex-grow mt-4"> <!-- flex-grow to make it responsive -->
                <input type="text"
                    wire:model.live.debounce.300ms="search"
                    class="bg-gray-100 text-gray-900 placeholder-gray-400 px-3 py-2 rounded-lg w-full outline-none focus:outline-none"
                    placeholder="Search . . . ">
                <span class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <i class="fas fa-search text-gray-400"></i>
                </span>
            </div>

            <div class="block w-48"> <!-- Set a fixed width for the select dropdown -->
                <select class="outline-none rounded border border-slate-500 w-full"
                    wire:model.live.debounce.300ms="filterPayment">
                    <option value="">All</option>
                    <option value="Gcash">Gcash</option>
                    <option value="Cash">Cash</option>
                </select>
            </div>
        </div>
    </div>

    <div class="w-full flex p-2 justify-center">
        <table class="w-full text-sm text-left rtl:text-right overflow-hidden">
            <thead class="text-xs uppercase bg-gray-100 ">
                <tr class="text-center">
                    <th class="py-2">Transaction Number{{ $filterPayment }}</th>
                    <th class="py-2">Payee Name</th>
                    <th class="py-2">Purpose</th>
                    <th class="py-2">Date</th>
                    <th class="py-2">Payment Method</th>
                    <th class="py-2">Amount</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                <tr class="text-center">
                    <td class="py-2">{{ $payment->ReferenceNumber }}</td>
                   <td class="py-2">
                    {{ $payment->guest ? $payment->guest->FirstName . ' ' . $payment->guest->LastName : 'N/A' }}
                </td>

                    <td class="py-2">{{ $payment->Purpose }}</td>
                    <td class="py-2">{{ $payment->DateCreated }}</td>
                    <td class="py-2">{{ $payment->PaymentType }}</td>
                    <td class="py-2">{{ $payment->AmountPaid }}</td>
                    <td class="py-2">
                        @if ($payment->Status == 'Confirmed')
                            <span
                                class="px-2 py-1 bg-green-500 text-white rounded-full text-xs">{{ $payment->Status }}</span>
                        @else
                            <span
                                class="px-2 py-1 bg-red-500 text-white rounded-full text-xs">{{ $payment->Status }}</span>
                        @endif
                    </td>
                    <td class="py-2">
                        <div class="flex justify-center">
                            <a href="{{ route('receipt', ['view' => $payment->ReferenceNumber]) }}" target="_blank"
                                class="rounded-full hover:bg-blue-400 px-2 py-1 hover:text-white">
                                <i class="fas fa-print"></i>
                            </a>
                            <button type="button" x-data x-click="paymentDetailsModal = true"
                                wire:click="selectPayments({{ $payment->PaymentId }})"
                                class="rounded-full hover:bg-green-400 px-2 py-1 hover:text-white"><i
                                    class="fas fa-eye"></i></button>
                        </div>
                    </td>
                </tr>
                
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="py-4 px-3">
        <div class="flex justify-between items-center">
            <div class="flex-1">
                <p class="text-sm text-gray-700 dark:text-gray-400">
                    Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of
                    {{ $payments->total() }} rooms
                </p>
            </div>
            <div class="flex items-center">
                @if ($payments->onFirstPage())
                    <span class="px-2 py-1 text-gray-500 bg-gray-200 rounded-l cursor-not-allowed">Previous</span>
                @else
                    <a href="{{ $payments->previousPageUrl() }}"
                        class="px-2 py-1 bg-cyan-500 text-white rounded-l hover:bg-cyan-600">Previous</a>
                @endif
    
                <!-- Page Number Links -->
                <div class="flex items-center mx-2">
                    @php
                        $currentPage = $payments->currentPage();
                        $lastPage = $payments->lastPage();
                        $visiblePages = 3; // Number of pages to show around the current page
                    @endphp
    
                    @if ($currentPage > 1)
                        <a href="{{ $payments->url(1) }}" class="px-2 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">1</a>
                    @endif
    
                    @if ($currentPage > $visiblePages + 1)
                        <span class="px-2 py-1 text-gray-500">...</span>
                    @endif
    
                    @for ($i = max(2, $currentPage - $visiblePages); $i <= min($lastPage - 1, $currentPage + $visiblePages); $i++)
                        @if ($i == $currentPage)
                            <span class="px-2 py-1 bg-cyan-500 text-white rounded cursor-not-allowed">{{ $i }}</span>
                        @else
                            <a href="{{ $payments->url($i) }}"
                                class="px-2 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">{{ $i }}</a>
                        @endif
                    @endfor
    
                    @if ($currentPage < $lastPage - $visiblePages)
                        <span class="px-2 py-1 text-gray-500">...</span>
                    @endif
    
                    @if ($lastPage > 1)
                        <a href="{{ $payments->url($lastPage) }}" class="px-2 py-1 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">{{ $lastPage }}</a>
                    @endif
                </div>
    
                @if ($payments->hasMorePages())
                    <a href="{{ $payments->nextPageUrl() }}"
                        class="px-2 py-1 bg-cyan-500 text-white rounded-r hover:bg-cyan-600">Next</a>
                @else
                    <span class="px-2 py-1 text-gray-500 bg-gray-200 rounded-r cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>
    </div>
    
    

    <x-modal name="payment-details-modal" title="Payment Details">
        @slot('body')
            <div class="p-4 md:p-5 text-center">
                <div class="grid grid-cols-3">
                    <div class="text-start font-bold">
                        <p class="text-sm ">Transaction Id</p>
                        <p class="text-sm ">Payee Name</p>
                        <p class="text-sm ">Purpose</p>
                        <p class="text-sm ">Date</p>
                        <p class="text-sm ">Payment Method</p>
                        <p class="text-sm ">Amount</p>
                        <p class="text-sm ">Status</p>
                    </div>
                    <div class="col-span-2 text-start">
                        @if ($selectPayment)
                            <p class="text-sm font-semibold">{{ $selectPayment->ReferenceNumber ?? 'N/A' }}</p>
                            <p class="text-sm font-semibold">
                                {{ $selectPayment->guest ? ($selectPayment->guest->FirstName ?? 'N/A') . ' ' . 
                                  ($selectPayment->guest->MiddleName[0] ?? 'N/A') . '. ' . 
                                  ($selectPayment->guest->LastName ?? 'N/A') : 'N/A' }}
                            </p>
                            <p class="text-sm font-semibold">{{ $selectPayment->Purpose ?? 'N/A' }}</p>
                            <p class="text-sm font-semibold">{{ $selectPayment->DateCreated ?? 'N/A' }}</p>
                            <p class="text-sm font-semibold">{{ $selectPayment->PaymentType ?? 'N/A' }}</p>
                            <p class="text-sm font-semibold">{{ $selectPayment->AmountPaid ?? 'N/A' }}</p>
                            <p class="text-sm font-semibold">{{ $selectPayment->Status ?? 'N/A' }}</p>
                        @else
                            <p class="text-sm font-semibold">N/A</p>
                        @endif
                    </div>
                </div>
            </div>
        @endslot
    </x-modal>

</div>
