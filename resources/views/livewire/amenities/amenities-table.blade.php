<div>

    <x-modal title="Create New Amenities" name="add-modal-amenities">
        @slot('body')
            <form wire:submit.prevent="createAmenities">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <x-text-field1 
                            name="name" 
                            placeholder="Type amenities name" 
                            model="name" 
                            label="Name" 
                            type="text" 
                        />
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">
                                <i class="fas fa-exclamation-circle"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <x-text-field1 
                            name="price" 
                            placeholder="Type amenities price" 
                            model="price" 
                            label="Price" 
                            type="number" 
                        />
                        @error('price')
                            <p class="text-red-500 text-xs italic mt-1">
                                <i class="fas fa-exclamation-circle"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                <button type="submit"
                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Add Amenities
                </button>
            </form>
        @endslot
    </x-modal>

    <div class="bg-gray-50 rounded shadow p-4">
        <h5 class="font-bold">Amenities Information</h5>
        <div class="relative mb-4">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search"
                class="bg-gray-100 text-gray-900 placeholder-gray-400 px-3 py-2 rounded-lg w-full outline-none focus:outline-none"
                placeholder="Search amenities... " 
                aria-label="Search amenities"
            />
            <span class="absolute inset-y-0 right-0 flex items-center pr-3">
                <i class="fas fa-search text-gray-400"></i>
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left bg-white shadow rounded-lg">
                <thead class="text-xs uppercase bg-gray-100">
                    <tr class="text-center">
                        <th class="py-1">Type</th>
                        <th class="py-2">Price</th>
                        <th class="py-2 ">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($amenities as $amenity)
                        <tr class="text-center hover:bg-gray-50">
                            <td class="py-3">{{ $amenity->Name }}</td>
                            <td class="py-3">{{ $amenity->Price }}</td>
                            <td class="py-3 flex justify-center space-x-2">
                                <button 
                                    x-data 
                                    x-on:click="$dispatch('open-modal', {name: 'delete-modal-{{ $amenity->AmenitiesId }}'})"
                                    class="p-2 hover:bg-red-100 text-red-600 rounded-full"
                                    aria-label="Delete Amenity"
                                >
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                                <button 
                                    wire:click="updateAmenities({{ $amenity->AmenitiesId }})"
                                    class="p-2 hover:bg-blue-100 text-blue-600 rounded-full"
                                    aria-label="Edit Amenity"
                                >
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>

                        <x-modal title="Delete Amenities" name="delete-modal-{{ $amenity->AmenitiesId }}">
                            @slot('body')
                                <div class="p-4 text-center">
                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <h3 class="mb-5 text-lg font-normal text-gray-500">Are you sure you want to delete this amenity?</h3>
                                    <button wire:click="delete({{ $amenity->AmenitiesId }})" type="button" class="text-white bg-red-600 hover:bg-red-800 rounded-lg px-5 py-2.5">
                                        Yes, I'm sure
                                    </button>
                                    <button 
                                        x-on:click="$dispatch('close-modal', {name: 'delete-modal-{{ $amenity->AmenitiesId }}'})"
                                        type="button"
                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100">
                                        No, cancel
                                    </button>
                                </div>
                            @endslot
                        </x-modal>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <x-modal title="Update Amenities" name="update-modal">
        @slot('body')
            <form wire:submit.prevent="update">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <x-text-field1 
                            name="update-name" 
                            placeholder="Enter amenities name" 
                            model="updateName" 
                            label="Name" 
                            type="text"
                        />
                    </div>
                    <div class="col-span-2">
                        <x-text-field1 
                            name="update-price" 
                            placeholder="Enter amenities price" 
                            model="updatePrice" 
                            label="Price" 
                            type="number" 
                        />
                    </div>
                </div>
                <button type="submit"
                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5">
                    Update Amenities
                </button>
            </form>
        @endslot
    </x-modal>

    @if (session()->has('message'))
        <x-success-message-modal message="{{ session('message') }}" />
    @endif

</div>
