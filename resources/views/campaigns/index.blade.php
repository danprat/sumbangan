@extends('layouts.app')

@section('title', 'Sumbangan - Transparent Giving')

@section('content')
<!-- Hero Section -->
<section class="max-w-max-width mx-auto px-margin-mobile md:px-margin-desktop py-xl flex flex-col items-center justify-center text-center">
    <h1 class="font-display-lg-mobile text-display-lg-mobile md:font-display-lg md:text-display-lg text-primary max-w-3xl mb-md">
        Empower Change Through Transparent Giving.
    </h1>
    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mb-lg">
        Join a community committed to institutional stability and radical transparency. Every donation is tracked, verified, and impactful.
    </p>
    <a href="#campaigns" class="bg-primary text-on-primary font-label-md text-label-md px-lg py-sm rounded-full hover:bg-primary-container hover:text-on-primary-container transition-all active:scale-95 text-lg inline-block">
        Start Donating
    </a>
</section>

<!-- Featured Campaigns -->
<section id="campaigns" class="max-w-max-width mx-auto px-margin-mobile md:px-margin-desktop py-xl">
    <div class="flex justify-between items-end mb-lg">
        <h2 class="font-headline-md text-headline-md text-primary">Featured Campaigns</h2>
        <a class="font-label-md text-label-md text-primary hover:underline flex items-center gap-xs" href="#">
            View All <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
        </a>
    </div>
    
    @if($campaigns->isEmpty())
        <div class="text-center py-16 bg-surface-container-lowest rounded-xl shadow-[0px_4px_20px_rgba(0,0,0,0.04)] border border-outline-variant/30">
            <p class="font-body-lg text-on-surface-variant">No campaigns available at the moment.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
            @foreach($campaigns as $campaign)
                <!-- Campaign Card -->
                <article class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0px_4px_20px_rgba(0,0,0,0.04)] hover:shadow-[0px_8px_30px_rgba(0,0,0,0.08)] transition-shadow duration-300 flex flex-col h-full border border-outline-variant/30">
                    <div class="h-48 overflow-hidden">
                        @if($campaign->image_path)
                            <img class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" alt="{{ $campaign->title }}" src="{{ Storage::disk('public')->url($campaign->image_path) }}"/>
                        @else
                            <div class="w-full h-full bg-surface-variant flex items-center justify-center transition-transform duration-500 hover:scale-105">
                                <span class="material-symbols-outlined text-4xl text-primary/30">image</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-md flex flex-col flex-grow">
                        <h3 class="font-headline-md text-headline-md text-primary mb-xs line-clamp-2">{{ $campaign->title }}</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant mb-md flex-grow line-clamp-3">{{ Str::limit($campaign->description, 100) }}</p>
                        
                        <div class="mb-md">
                            <div class="flex justify-between font-label-sm text-label-sm text-on-surface-variant mb-xs">
                                <span>Raised: Rp {{ number_format($campaign->totalVerifiedAmount(), 0, ',', '.') }}</span>
                                <span>Target: Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="h-[12px] bg-progress-track rounded-full overflow-hidden shadow-inner">
                                <div class="h-full bg-secondary rounded-full" style="width: {{ $campaign->progressPercentage() }}%"></div>
                            </div>
                        </div>
                        <a href="{{ route('campaigns.show', $campaign->slug) }}" class="w-full block text-center bg-primary-container text-on-primary-container font-label-md text-label-md py-sm rounded-full hover:bg-primary hover:text-on-primary transition-all active:scale-95">
                            Donate Now
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</section>
@endsection
