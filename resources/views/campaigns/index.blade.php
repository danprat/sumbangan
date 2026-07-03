@extends('layouts.app')

@section('title', 'Campaign Penggalangan Dana')

@section('content')
<div>
    <div class="text-center">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">Campaign Penggalangan Dana</h1>
        <p class="mt-2 text-gray-500">Pilih campaign yang ingin Anda dukung dan salurkan kebaikan Anda.</p>
    </div>

    @if($campaigns->isEmpty())
        <div class="mt-12 text-center">
            <p class="text-gray-500">Belum ada campaign yang tersedia.</p>
        </div>
    @else
        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($campaigns as $campaign)
                <x-campaign-card :campaign="$campaign" />
            @endforeach
        </div>
    @endif
</div>
@endsection
