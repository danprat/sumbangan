@extends('layouts.admin')

@section('title', 'Donasi')

@section('content')
<div>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Donasi</h1>
            <p class="mt-1 text-sm text-gray-500">Daftar donasi dengan filter status.</p>
        </div>
    </div>

    <div class="mt-4 flex gap-x-2">
        <a href="{{ route('admin.donations.index') }}"
           class="rounded-md px-3 py-1.5 text-sm font-semibold {{ !$currentStatus ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 ring-1 ring-inset ring-gray-300' }}">
            Semua
        </a>
        <a href="{{ route('admin.donations.index', ['status' => 'pending']) }}"
           class="rounded-md px-3 py-1.5 text-sm font-semibold {{ $currentStatus === 'pending' ? 'bg-amber-600 text-white' : 'bg-white text-gray-700 ring-1 ring-inset ring-gray-300' }}">
            Pending
        </a>
        <a href="{{ route('admin.donations.index', ['status' => 'verified']) }}"
           class="rounded-md px-3 py-1.5 text-sm font-semibold {{ $currentStatus === 'verified' ? 'bg-green-600 text-white' : 'bg-white text-gray-700 ring-1 ring-inset ring-gray-300' }}">
            Diverifikasi
        </a>
        <a href="{{ route('admin.donations.index', ['status' => 'rejected']) }}"
           class="rounded-md px-3 py-1.5 text-sm font-semibold {{ $currentStatus === 'rejected' ? 'bg-red-600 text-white' : 'bg-white text-gray-700 ring-1 ring-inset ring-gray-300' }}">
            Ditolak
        </a>
    </div>

    <div class="mt-6 overflow-hidden rounded-lg bg-white shadow">
        @if($donations->isEmpty())
            <div class="p-6 text-center text-sm text-gray-500">
                Tidak ada donasi.
            </div>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Donatur</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campaign</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nominal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($donations as $donation)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $donation->donor_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $donation->campaign?->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($donation->status === 'pending')
                                <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-1 text-xs font-medium text-amber-700">Pending</span>
                            @elseif($donation->status === 'verified')
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">Diverifikasi</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-700">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $donation->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-right">
                            <a href="{{ route('admin.donations.show', $donation) }}" class="font-medium text-indigo-600 hover:text-indigo-500">Detail</a>
                            @if($donation->status === 'pending')
                                <button onclick="document.getElementById('verify-form-{{ $donation->id }}').submit()"
                                        class="ml-2 font-medium text-green-600 hover:text-green-500">Verifikasi</button>
                                <form id="verify-form-{{ $donation->id }}" action="{{ route('admin.donations.verify', $donation) }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="px-6 py-4 border-t border-gray-200">
                {{ $donations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
