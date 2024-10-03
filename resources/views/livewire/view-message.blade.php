<div class="w-full h-screen shadow rounded overflow-hidden z-0">
    <div class="grid grid-cols-12 h-full">

        <!-- Sidebar: Contact List -->
        <div class="col-span-3 bg-gray-100 p-4 border-r border-gray-300">
            <!-- Search bar -->
            <div class="flex justify-between items-center mb-4 gap-2">
                <input type="text" 
                       class="w-full p-2 border border-gray-300 rounded" 
                       placeholder="Search" 
                       wire:model.live='search'>
            </div>

            <div class="text-xl font-semibold mb-2">All Messages</div>

            <!-- Contacts List -->
            <div class="space-y-4">
                @foreach ($guests as $guest)
                    <div class="p-2 bg-white rounded shadow-sm cursor-pointer hover:bg-gray-200">
                        <button class="flex justify-between items-start outline-none w-full"
                                wire:click="selectGuest({{ $guest->GuestId }})"
                                aria-label="Select {{ $guest->FirstName . ' ' . $guest->LastName }}">
                            <h3 class="font-bold">{{ $guest->FirstName . ' ' . $guest->LastName }}</h3>
                            @if ($guest->messages->where('is_read', false)->isNotEmpty())
                                @php
                                    $latestMessage = $guest->messages->where('is_read', false)->first(); // Get the latest unread message
                                @endphp
                                <span>{{ \Carbon\Carbon::createFromFormat('H:i:s', $latestMessage->TimeSent)->format('h:i A') }}</span>
                            @endif
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-span-9 relative bg-white">

            <!-- Chat Header -->
            <div class="p-4 bg-cyan-100 border-b border-gray-300 min-h-16 z-0">
                <h1 class="text-2xl font-bold">
                    @if ($selectedGuest)
                        {{ $selectedGuest->FirstName . ' ' . $selectedGuest->LastName }}
                    @endif
                </h1>
            </div>

            <div class="h-full overflow-y-auto p-4" style="height: calc(100vh - 150px);" wire:poll.debounce.1000ms>
                @if ($selectedGuest)
                    @foreach ($selectedGuest->messages->where('is_read', false) as $message)
                        <div class="mb-4 {{ $message->isGuestMessage === 0 ? 'text-right' : 'text-left' }}">
                            @if ($message->isGuestMessage === 1)
                                <div class="bg-blue-500 text-white p-2 rounded-lg inline-block text-lg">
                                    <p>{{ $message->Message }}</p>
                                    <span class="text-xs">{{ \Carbon\Carbon::createFromFormat('H:i:s', $message->TimeSent)->format('h:i A') }}</span>
                                </div>
                            @else
                                <div class="bg-gray-200 p-2 rounded-lg inline-block">
                                    <p>{{ $message->Message }}</p>
                                    <span class="text-xs text-slate-400">{{ \Carbon\Carbon::createFromFormat('H:i:s', $message->TimeSent)->format('h:i A') }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-center text-gray-500">Select a guest to see unread messages.</p>
                @endif
            </div>

            <form wire:submit.prevent="sendMessage">
                <div class="absolute bottom-0 w-full bg-gray-100 border-t border-gray-300 p-4">
                    <div class="flex items-center space-x-2">
                        <textarea class="w-full p-2 border border-gray-300 rounded-lg resize-none" 
                                  rows="2" 
                                  wire:model="message"
                                  placeholder="Type your message..."
                                  aria-label="Message input"></textarea>
                        <button type="submit" class="bg-blue-500 text-white p-3 rounded-lg" aria-label="Send Message">Send</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>
