@extends('layouts.app')

@section('content')
    
    <div class="container mx-auto px-4 py-8">
        
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Find People</h2>
            <form action="{{ route('users.search') }}" method="GET" class="relative">
                <input type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Search for friends by name..." 
                    class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm"
                >
                <button type="submit" class="absolute right-2 top-2 bg-blue-600 text-white p-1.5 rounded-md hover:bg-blue-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($users as $user)
                <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="h-20 bg-gradient-to-r from-blue-400 to-indigo-500"></div>

                    <div class="px-6 pb-6 relative">
                        <div class="-mt-10 mb-4">
                            <img class="h-20 w-20 rounded-full border-4 border-white shadow-sm bg-white" 
                                src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" 
                                alt="{{ $user->name }}">
                        </div>

                        <div class="mb-5">
                            <h3 class="text-lg font-bold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500">Member since {{ $user->created_at->format('Y') }}</p>
                        </div>
                        @if(auth()->user()->hasSentRequestTo($user)) 
                            <button disabled class="w-full flex justify-center items-center px-4 py-2 bg-gray-100 text-gray-500 text-sm font-medium rounded-md cursor-not-allowed">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Request Sent
                            </button>
                        @elseif(auth()->user()->hasReceivedRequestFrom($user)) 
                            <div class="flex gap-3">
                                <form action="{{ route('friend-requests.accept', auth()->user()->hasReceivedRequestFrom($user)->id) }}" method="POST" class="w-full" onsubmit="return confirm('Are You Sure?')">
                                    @csrf
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 shadow-sm">
                                        Confirm
                                    </button>
                                </form>

                                <form action="{{ route('friend-requests.reject', auth()->user()->hasReceivedRequestFrom($user)->id) }}" method="POST" class="w-full" onsubmit="return confirm('Are You Sure?')">
                                    @csrf
                                    <input type="hidden" name="status" value="reject">
                                    <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg transition duration-200 border border-gray-300">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @elseif(auth()->user()->isFriendsWith($user))
                            <button disabled class="w-full flex justify-center items-center px-4 py-2 bg-green-400 text-white text-sm font-medium rounded-md cursor-not-allowed">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Already Friends
                            </button>
                        @else
                            <form action="{{ route('friend-requests.sent', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out shadow-sm">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                    Add Friend
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-10 text-gray-500">
                    No users found matching your search.
                </div>
            @endforelse
        </div>
    </div>

@endsection
