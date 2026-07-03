@extends('layouts.admin')

@section('title', 'Tambah Rekening Bank')

@section('content')
<div class="max-w-xl">
    <h1 class="text-2xl font-bold tracking-tight text-gray-900">Tambah Rekening Bank</h1>

    <form action="{{ route('admin.bank-accounts.store') }}" method="POST" class="mt-6 space-y-6">
        @csrf

        <div>
            <label for="bank_name" class="block text-sm font-medium text-gray-900">Nama Bank</label>
            <div class="mt-2">
                <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name') }}" required
                       class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
            </div>
            @error('bank_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="account_name" class="block text-sm font-medium text-gray-900">Nama Pemilik Rekening</label>
            <div class="mt-2">
                <input type="text" name="account_name" id="account_name" value="{{ old('account_name') }}" required
                       class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
            </div>
            @error('account_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="account_number" class="block text-sm font-medium text-gray-900">Nomor Rekening</label>
            <div class="mt-2">
                <input type="text" name="account_number" id="account_number" value="{{ old('account_number') }}" required
                       class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
            </div>
            @error('account_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-x-3">
            <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                Simpan
            </button>
            <a href="{{ route('admin.bank-accounts.index') }}"
               class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
