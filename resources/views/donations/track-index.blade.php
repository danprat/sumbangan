@extends('layouts.app')

@section('title', 'Lacak Donasi - Sumbangan')

@section('content')
<div class="max-w-xl mx-auto py-12">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 text-indigo-600 mb-4">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Lacak Status Donasi</h1>
            <p class="mt-2 text-gray-500">Masukkan kode token donasi yang Anda terima untuk melihat status verifikasi.</p>
        </div>

        <form action="{{ route('donation.track.search') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="token" class="block text-sm font-medium text-gray-700">Kode Token Donasi</label>
                <div class="mt-2">
                    <input type="text" name="token" id="token" value="{{ old('token') }}" required placeholder="Contoh: DON-12345678"
                           class="block w-full rounded-xl border-gray-300 py-3 px-4 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                @error('token')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                Lacak Donasi
            </button>
        </form>
    </div>
</div>
@endsection
