@extends('layouts.app')

@section('title', 'Lacak Donasi - Sumbangan')

@section('content')
<main class="flex-grow flex flex-col items-center justify-center py-xl px-margin-mobile md:px-margin-desktop w-full max-w-max-width mx-auto">
    <div class="text-center mb-lg max-w-2xl mx-auto">
        <h1 class="font-display-lg-mobile text-display-lg-mobile md:font-display-lg md:text-display-lg text-on-surface mb-xs">Track Your Impact</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant">Masukkan token donasi unik Anda untuk melacak status verifikasi kontribusi dengan aman dan transparan.</p>
    </div>

    <div class="w-full max-w-xl bg-surface-container-lowest rounded-xl p-md shadow-[0px_4px_20px_rgba(0,0,0,0.04)] mb-xl relative z-10 border border-surface-container-low">
        <form action="{{ route('donation.track.search') }}" method="POST" class="flex flex-col gap-sm" id="trackForm">
            @csrf
            <label class="sr-only" for="token">Masukkan token donasi Anda</label>
            <div class="relative w-full">
                <span class="material-symbols-outlined absolute left-sm top-1/2 -translate-y-1/2 text-outline-variant">search</span>
                <input
                    aria-describedby="tokenHelp"
                    class="w-full pl-xl pr-sm py-sm rounded-lg border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary font-body-md text-body-md text-on-surface bg-surface-container-lowest transition-colors"
                    id="token"
                    name="token"
                    placeholder="Masukkan token donasi Anda"
                    required
                    type="text"
                    value="{{ old('token') }}"
                />
            </div>
            <p class="font-label-sm text-label-sm text-on-surface-variant px-xs" id="tokenHelp">Token dikirim setelah donasi berhasil dikirim.</p>
            @error('token')
                <p class="font-label-sm text-label-sm text-error px-xs">{{ $message }}</p>
            @enderror
            <button class="mt-xs bg-primary text-on-primary font-label-md text-label-md px-md py-sm rounded-lg hover:bg-on-primary-fixed-variant transition-colors duration-200 w-full flex items-center justify-center gap-xs" type="submit">
                <span>Lacak Donasi</span>
                <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </form>
    </div>
</main>
@endsection
