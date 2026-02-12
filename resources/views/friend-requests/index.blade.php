@extends('layouts.app')

@section('content')

    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Friend Requests</h2>

        @if($requests->isEmpty())
            <div class="bg-blue-50 text-blue-700 p-4 rounded-lg">
                No pending friend requests.
            </div>
            <div>
                <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{ route('users.search') }}">
                Find Friends
            </a>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($requests as $request)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        @if ($request->sender->id === Auth::id())
                            <div class="flex items-center space-x-4 mb-4">
                                <img class="h-14 w-14 rounded-full bg-gray-200 object-cover" 
                                    src="https://ui-avatars.com/api/?name={{ urlencode($request->receiver->name) }}&background=random" 
                                    alt="{{ $request->receiver->name }}">
                                
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg">{{ $request->receiver->name }}</h3>
                                    <p class="text-sm text-gray-500">
                                        Sent {{ $request->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <form action="{{ route('friend-requests.reject', $request->id) }}" method="POST" class="w-full" onsubmit="return confirm('Are You Sure?')">
                                @csrf
                                <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg transition duration-200 border border-gray-300">
                                    Delete
                                </button>
                            </form>
                        @else
                            <div class="flex items-center space-x-4 mb-4">
                                <img class="h-14 w-14 rounded-full bg-gray-200 object-cover" 
                                    src="https://ui-avatars.com/api/?name={{ urlencode($request->sender->name) }}&background=random" 
                                    alt="{{ $request->sender->name }}">
                                
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg">{{ $request->sender->name }}</h3>
                                    <p class="text-sm text-gray-500">
                                        Sent {{ $request->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <form action="{{ route('friend-requests.accept', $request->id) }}" method="POST" class="w-full" onsubmit="return confirm('Are You Sure?')">
                                    @csrf
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 shadow-sm">
                                        Confirm
                                    </button>
                                </form>

                                <form action="{{ route('friend-requests.reject', $request->id) }}" method="POST" class="w-full" onsubmit="return confirm('Are You Sure?')">
                                    @csrf
                                    <input type="hidden" name="status" value="reject">
                                    <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-lg transition duration-200 border border-gray-300">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection