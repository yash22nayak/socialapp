@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-gray-100 px-6 py-4 border-b border-gray-200 font-semibold text-gray-700">
                    {{ __('Verify Your Email Address') }}
                </div>

                <div class="p-6">
                    @if (session('resent'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <p class="mb-2 text-gray-700">
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                    </p>
                    <p class="mb-4 text-gray-700">
                        {{ __('If you did not receive the email') }},
                    </p>
                    
                    <form class="inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="text-blue-600 hover:text-blue-800 underline focus:outline-none">
                            {{ __('click here to request another') }}
                        </button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection