@extends('layouts.app')

@section('title', $campaign->title)

@section('content')
<div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        @if($campaign->image_path)
            <img src="{{ Storage::disk('public')->url($campaign->image_path) }}"
                 alt="{{ $campaign->title }}"
                 class="w-full rounded-lg object-cover max-h-96">
        @endif

        <h1 class="mt-4 text-2xl font-bold tracking-tight text-gray-900">{{ $campaign->title }}</h1>

        @if($campaign->description)
            <div class="mt-4 text-gray-600 leading-relaxed whitespace-pre-line">
                {{ $campaign->description }}
            </div>
        @endif

        <!-- Progress -->
        <div class="mt-6 rounded-lg bg-white p-6 shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Terkumpul</p>
                    <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($campaign->totalVerifiedAmount(), 0, ',', '.') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Target</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="mt-4 w-full rounded-full bg-gray-200 h-3">
                <div class="h-3 rounded-full {{ $campaign->progressPercentage() >= 100 ? 'bg-green-500' : 'bg-indigo-600' }}"
                     style="width: {{ $campaign->progressPercentage() }}%"></div>
            </div>

            <div class="mt-2 flex items-center justify-between text-sm text-gray-500">
                <span>{{ $campaign->progressPercentage() }}% tercapai</span>
                @if($campaign->isCompleted())
                    <span class="text-gray-400">Campaign selesai</span>
                @else
                    <span>{{ $campaign->remainingDays() }} hari lagi</span>
                @endif
            </div>
        </div>

        @if($campaign->isCompleted())
            <div class="mt-6 rounded-lg bg-gray-100 p-4 text-center">
                <p class="text-gray-600 font-medium">Campaign ini telah berakhir.</p>
                <p class="text-sm text-gray-500 mt-1">Terima kasih kepada seluruh donatur yang telah berpartisipasi.</p>
            </div>
        @endif

        <!-- Verified Donors -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-900">Donatur ({{ $verifiedDonations->count() }})</h2>

            @if($verifiedDonations->isEmpty())
                <p class="mt-3 text-gray-500">Belum ada donasi terverifikasi. Jadilah yang pertama!</p>
            @else
                <div class="mt-4 overflow-hidden rounded-lg bg-white shadow">
                    <ul class="divide-y divide-gray-200">
                        @foreach($verifiedDonations as $donation)
                            <li class="flex items-center justify-between px-6 py-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $donation->donor_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $donation->created_at->format('d M Y') }}</p>
                                </div>
                                <p class="text-sm font-semibold text-indigo-600">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1">
        @if(!$campaign->isCompleted())
            <!-- Donation Form -->
            <div class="rounded-lg bg-white p-6 shadow">
                <h3 class="text-lg font-semibold text-gray-900">Form Donasi</h3>

                @if ($errors->any())
                    <div class="mt-3 rounded-md bg-red-50 p-3 text-sm text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mt-3 rounded-md bg-red-50 p-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('campaigns.donate', $campaign->slug) }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
                    @csrf

                    <div>
                        <label for="donor_name" class="block text-sm font-medium text-gray-900">Nama</label>
                        <input type="text" name="donor_name" id="donor_name" value="{{ old('donor_name') }}" required
                               class="mt-1 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
                    </div>

                    <div>
                        <label for="donor_email" class="block text-sm font-medium text-gray-900">Email</label>
                        <input type="email" name="donor_email" id="donor_email" value="{{ old('donor_email') }}"
                               class="mt-1 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
                    </div>

                    <div>
                        <label for="donor_phone" class="block text-sm font-medium text-gray-900">No. Telepon</label>
                        <input type="text" name="donor_phone" id="donor_phone" value="{{ old('donor_phone') }}"
                               class="mt-1 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-900">Nominal (Rp)</label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="1000" step="1"
                               class="mt-1 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
                    </div>

                    <div>
                        <label for="proof_image" class="block text-sm font-medium text-gray-900">Bukti Transfer</label>
                        <input type="file" name="proof_image" id="proof_image" accept="image/jpeg,image/png,image/jpg" required
                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700">
                        <p class="mt-1 text-xs text-gray-500">JPG/PNG, maksimal 2MB.</p>
                    </div>

                    <button type="submit"
                            class="w-full rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        Kirim Donasi
                    </button>
                </form>
            </div>
        @endif

        <!-- Bank Accounts -->
        @if($bankAccounts->isNotEmpty())
            <div class="mt-6 rounded-lg bg-white p-6 shadow">
                <h3 class="text-lg font-semibold text-gray-900">Transfer ke Rekening</h3>
                <p class="mt-1 text-sm text-gray-500">Silakan transfer donasi Anda ke salah satu rekening berikut:</p>

                <div class="mt-4 space-y-3">
                    @foreach($bankAccounts as $account)
                        <div class="rounded-md border border-gray-200 p-3">
                            <p class="text-sm font-semibold text-gray-900">{{ $account->bank_name }}</p>
                            <p class="text-sm text-gray-600">{{ $account->account_number }}</p>
                            <p class="text-xs text-gray-500">a.n. {{ $account->account_name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
