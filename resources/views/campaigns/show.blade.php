@extends('layouts.app')

@section('title', $campaign->title)

@section('content')
<main class="flex-1 w-full max-w-max-width mx-auto px-margin-mobile md:px-0 py-lg grid grid-cols-1 md:grid-cols-12 gap-gutter">
    <div class="md:col-span-12 mb-sm flex items-center gap-2 text-label-sm font-label-sm text-on-surface-variant">
        <a class="hover:text-primary transition-colors" href="{{ route('campaigns.index') }}">Home</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="{{ route('campaigns.index') }}#campaigns">Campaigns</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-primary font-bold truncate">{{ $campaign->title }}</span>
    </div>

    <div class="md:col-span-8 flex flex-col gap-lg">
        <div class="w-full aspect-video rounded-xl overflow-hidden shadow-sm bg-surface-container-low relative">
            @if($campaign->image_path)
                <img class="w-full h-full object-cover absolute inset-0" src="{{ Storage::disk('public')->url($campaign->image_path) }}" alt="{{ $campaign->title }}">
            @else
                <div class="w-full h-full flex items-center justify-center absolute inset-0 bg-surface-container text-primary">
                    <span class="material-symbols-outlined text-7xl">volunteer_activism</span>
                </div>
            @endif
            <div class="absolute top-4 left-4 bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-label-sm font-label-sm flex items-center gap-1 shadow-sm">
                <span class="material-symbols-outlined text-[16px]">verified</span>
                Verified Cause
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-xl p-md shadow-[0px_4px_20px_rgba(0,0,0,0.04)] flex flex-col gap-sm">
            <h1 class="text-display-lg-mobile md:text-display-lg font-display-lg-mobile md:font-display-lg text-on-background">{{ $campaign->title }}</h1>
            <div class="flex flex-col sm:flex-row sm:flex-wrap gap-4 text-on-surface-variant text-label-md font-label-md border-b border-outline-variant pb-sm">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">calendar_today</span>
                    @if($campaign->isCompleted())
                        Selesai
                    @else
                        Berakhir dalam {{ $campaign->remainingDays() }} hari
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">monitoring</span>
                    {{ $campaign->progressPercentage() }}% tercapai
                </div>
            </div>
            @if($campaign->description)
                <div class="text-body-md font-body-md text-on-surface-variant leading-relaxed space-y-4 pt-sm whitespace-pre-line">{{ $campaign->description }}</div>
            @endif
        </div>

        <div class="bg-surface-container-lowest rounded-xl p-md shadow-[0px_4px_20px_rgba(0,0,0,0.04)] flex flex-col gap-sm">
            <div class="flex justify-between items-end mb-1 gap-sm">
                <div class="text-headline-md font-headline-md text-primary">Rp {{ number_format($campaign->totalVerifiedAmount(), 0, ',', '.') }}</div>
                <div class="text-label-md font-label-md text-on-surface-variant text-right">terkumpul dari Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</div>
            </div>
            <div class="w-full bg-surface-container h-3 rounded-full overflow-hidden relative">
                <div class="absolute left-0 top-0 h-full {{ $campaign->progressPercentage() >= 100 ? 'bg-secondary' : 'bg-primary' }} rounded-full" style="width: {{ $campaign->progressPercentage() }}%"></div>
            </div>
            <div class="flex justify-between text-label-sm font-label-sm text-on-surface-variant mt-1">
                <span>{{ $campaign->progressPercentage() }}% Funded</span>
                <span>{{ $verifiedDonations->count() }} Donors</span>
            </div>
        </div>

        @if($campaign->isCompleted())
            <div class="bg-surface-container rounded-xl p-md text-center border border-outline-variant">
                <p class="text-on-surface font-semibold">Campaign ini telah berakhir.</p>
                <p class="text-label-md font-label-md text-on-surface-variant mt-xs">Terima kasih kepada seluruh donatur yang telah berpartisipasi.</p>
            </div>
        @endif

        <div class="bg-surface-container-lowest rounded-xl p-md shadow-[0px_4px_20px_rgba(0,0,0,0.04)] flex flex-col gap-sm">
            <h3 class="text-body-lg font-body-lg text-on-background border-b border-outline-variant pb-2">Donatur Terverifikasi ({{ $verifiedDonations->count() }})</h3>
            @if($verifiedDonations->isEmpty())
                <p class="text-body-md font-body-md text-on-surface-variant">Belum ada donasi terverifikasi. Jadilah yang pertama!</p>
            @else
                <ul class="space-y-3">
                    @foreach($verifiedDonations as $donation)
                        <li class="flex justify-between items-center text-label-md font-label-md gap-sm">
                            <div class="flex items-center gap-2 min-w-0">
                                <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-primary shrink-0">
                                    {{ strtoupper(mb_substr($donation->donor_name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <span class="text-on-surface block truncate">{{ $donation->donor_name }}</span>
                                    <span class="text-label-sm text-on-surface-variant">{{ $donation->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                            <span class="text-on-surface-variant font-medium shrink-0">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="md:col-span-4 flex flex-col gap-md">
        @if(!$campaign->isCompleted())
            <div class="bg-surface-container-lowest rounded-xl p-md shadow-[0px_4px_20px_rgba(0,0,0,0.04)]">
                <h3 class="text-headline-md font-headline-md text-on-background mb-sm">Make a Donation</h3>

                @if ($errors->any())
                    <div class="mb-sm rounded-lg border border-error bg-error-container p-sm text-label-md text-on-error-container">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-sm rounded-lg border border-error bg-error-container p-sm text-label-md text-on-error-container">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('campaigns.donate', $campaign->slug) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
                    @csrf
                    <div class="grid grid-cols-3 gap-2">
                        <button class="border border-outline-variant hover:border-primary text-on-surface hover:text-primary rounded-lg py-2 text-label-md font-label-md transition-colors bg-surface-bright focus:ring-2 focus:ring-primary outline-none" type="button" data-amount="50000">Rp 50k</button>
                        <button class="border border-outline-variant hover:border-primary text-on-surface hover:text-primary rounded-lg py-2 text-label-md font-label-md transition-colors bg-surface-bright focus:ring-2 focus:ring-primary outline-none" type="button" data-amount="100000">Rp 100k</button>
                        <button class="border border-outline-variant hover:border-primary text-on-surface hover:text-primary rounded-lg py-2 text-label-md font-label-md transition-colors bg-surface-bright focus:ring-2 focus:ring-primary outline-none" type="button" data-amount="500000">Rp 500k</button>
                    </div>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant font-label-md">Rp</span>
                        <input class="w-full pl-10 pr-3 py-2 border border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-surface-bright text-body-md text-on-surface transition-colors" id="amount" min="1000" name="amount" placeholder="Nominal Donasi" required step="1" type="number" value="{{ old('amount') }}"/>
                    </div>
                    <input class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-surface-bright text-body-md text-on-surface transition-colors" id="donor_name" name="donor_name" placeholder="Nama Lengkap" required type="text" value="{{ old('donor_name') }}"/>
                    <input class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-surface-bright text-body-md text-on-surface transition-colors" id="donor_email" name="donor_email" placeholder="Alamat Email" type="email" value="{{ old('donor_email') }}"/>
                    <input class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-surface-bright text-body-md text-on-surface transition-colors" id="donor_phone" name="donor_phone" placeholder="Nomor Telepon (Opsional)" type="tel" value="{{ old('donor_phone') }}"/>
                    <div class="flex flex-col gap-1">
                        <label class="text-label-sm font-label-sm text-on-surface-variant" for="proof_image">Bukti Transfer (JPG/PNG)</label>
                        <input accept="image/jpeg,image/png,image/jpg" class="w-full px-3 py-2 border border-outline-variant rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none bg-surface-bright text-body-md text-on-surface transition-colors file:mr-4 file:rounded-lg file:border-0 file:bg-surface-container file:px-3 file:py-2 file:text-label-md file:font-label-md file:text-primary" id="proof_image" name="proof_image" required type="file"/>
                        <p class="text-label-sm font-label-sm text-on-surface-variant">Upload file JPG atau PNG, maksimal 2MB.</p>
                    </div>
                    <button class="w-full bg-primary hover:bg-primary-container text-on-primary font-bold py-3 rounded-lg shadow-sm mt-2 transition-transform active:scale-95 text-label-md" type="submit">
                        Confirm Donation
                    </button>
                    <p class="text-[10px] text-center text-on-surface-variant mt-1 flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">lock</span>
                        Secure institutional processing
                    </p>
                </form>
            </div>
        @endif

        @if($bankAccounts->isNotEmpty())
            <div class="bg-surface-container-lowest rounded-xl p-md shadow-[0px_4px_20px_rgba(0,0,0,0.04)] flex flex-col gap-sm">
                <h3 class="text-body-lg font-body-lg text-on-background border-b border-outline-variant pb-2">Rekening Tujuan</h3>
                <ul class="space-y-3">
                    @foreach($bankAccounts as $account)
                        <li class="rounded-lg border border-outline-variant p-sm bg-surface-container-low">
                            <p class="text-label-md font-label-md text-on-surface">{{ $account->bank_name }}</p>
                            <p class="text-body-md font-body-md text-on-surface mt-xs">{{ $account->account_number }}</p>
                            <p class="text-label-sm font-label-sm text-on-surface-variant mt-xs">a.n. {{ $account->account_name }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</main>

@if(!$campaign->isCompleted())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const amountInput = document.getElementById('amount');
            const presetButtons = document.querySelectorAll('[data-amount]');

            presetButtons.forEach((button) => {
                button.addEventListener('click', function () {
                    amountInput.value = this.dataset.amount;
                    amountInput.focus();
                });
            });
        });
    </script>
@endif
@endsection
