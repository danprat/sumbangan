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
            <a href="{{ route('admin.bank-accounts.create') }}"
               class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                Tambah Rekening
            </a>
        </div>
    </div>

    <div class="mt-8 overflow-hidden rounded-lg bg-white shadow">
        @if($bankAccounts->isEmpty())
            <div class="p-6 text-center text-sm text-gray-500">
                Belum ada rekening bank. Klik "Tambah Rekening" untuk menambahkan.
            </div>
        @else
            <table class="min-w-full divide-y divide-gray-200">
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
                        <td class="px-6 py-4 text-sm text-right space-x-3">
                            <a href="{{ route('admin.bank-accounts.edit', $account) }}" class="text-indigo-600 hover:text-indigo-500">Edit</a>
                            <form action="{{ route('admin.bank-accounts.destroy', $account) }}" method="POST" class="inline" onsubmit="return confirm('Hapus rekening ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-500">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
