@extends('layouts.admin')

@section('title', 'Rekening Bank')

@section('content')
<div class="space-y-lg">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-display-lg-mobile font-display-lg text-on-background">Rekening Bank</h1>
            <p class="mt-2 text-body-md text-on-surface-variant">Kelola rekening tujuan transfer yang tampil di halaman campaign publik.</p>
        </div>
        <x-admin.button as="a" href="{{ route('admin.bank-accounts.create') }}" variant="primary">
            <span class="material-symbols-outlined text-lg">add</span>
            Tambah Rekening
        </x-admin.button>
    </div>

    <x-admin.card class="overflow-hidden">
        @if($bankAccounts->isEmpty())
            <x-admin.empty-state>
                Belum ada rekening bank. Klik "Tambah Rekening" untuk menambahkan.
            </x-admin.empty-state>
        @else
            <x-admin.table>
                <thead class="bg-surface-container-low text-label-sm font-label-sm uppercase text-on-surface-variant">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">Bank</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Nama Pemilik</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Nomor Rekening</th>
                        <th scope="col" class="px-6 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/40">
                    @foreach($bankAccounts as $account)
                    <tr class="hover:bg-surface-container/30 transition-colors">
                        <td class="px-6 py-5 font-semibold text-on-background">{{ $account->bank_name }}</td>
                        <td class="px-6 py-5 text-on-surface-variant">{{ $account->account_name }}</td>
                        <td class="px-6 py-5 text-on-surface-variant">{{ $account->account_number }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-end gap-3">
                                <x-admin.button as="a" href="{{ route('admin.bank-accounts.edit', $account) }}" variant="secondary">Edit</x-admin.button>
                                <form action="{{ route('admin.bank-accounts.destroy', $account) }}" method="POST" onsubmit="return confirm('Hapus rekening ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-admin.button type="submit" variant="danger">Hapus</x-admin.button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </x-admin.table>
        @endif
    </x-admin.card>
</div>
@endsection
