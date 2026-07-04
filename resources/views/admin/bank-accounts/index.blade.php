@extends('layouts.admin')

@section('title', 'Rekening Bank')

@section('content')
<div>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">Rekening Bank</h1>
            <p class="mt-1 text-sm text-gray-500">Daftar rekening bank yang ditampilkan di halaman campaign sebagai tujuan transfer.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <x-admin.button as="a" href="{{ route('admin.bank-accounts.create') }}" variant="primary">
                Tambah Rekening
            </x-admin.button>
        </div>
    </div>

    <x-admin.card class="mt-8 overflow-hidden">
        @if($bankAccounts->isEmpty())
            <x-admin.empty-state>
                Belum ada rekening bank. Klik "Tambah Rekening" untuk menambahkan.
            </x-admin.empty-state>
        @else
            <x-admin.table>
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bank</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pemilik</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor Rekening</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($bankAccounts as $account)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $account->bank_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $account->account_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $account->account_number }}</td>
                        <td class="px-6 py-4 text-sm text-right space-x-2">
                            <x-admin.button as="a" href="{{ route('admin.bank-accounts.edit', $account) }}" variant="secondary">Edit</x-admin.button>
                            <form action="{{ route('admin.bank-accounts.destroy', $account) }}" method="POST" class="inline" onsubmit="return confirm('Hapus rekening ini?')">
                                @csrf
                                @method('DELETE')
                                <x-admin.button type="submit" variant="danger">Hapus</x-admin.button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </x-admin.table>
        @endif
    </x-admin.card>
</div>
@endsection
