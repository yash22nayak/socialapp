@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">My Friends</h2>

    @if (!$friends->isEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($friends as $friend)
                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            {{-- <div class="flex-shrink-0">
                                <img class="h-12 w-12 rounded-full object-cover bg-gray-200" 
                                    src="https://ui-avatars.com/api/?name={{ urlencode($friend->name) }}&background=random" 
                                    alt="{{ $friend->name }}">
                            </div> --}}
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $friend->name }}</h3>
                                <p class="text-sm text-gray-500">
                                    Member since {{ $friend->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <form action="{{ route('friend-requests.unfriend', $friend->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unfriend {{ $friend->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-md transition duration-150 ease-in-out">
                                Unfriend
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col gap-2">
            <p>You have no friends yet.</p>
            <p>Make some... friends!</p>
            <div>
                <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" href="{{ route('users.search') }}">
                Find Friends
            </a>
            </div>
        </div>
    @endif
</div>
@endsection
