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
                <x-admin.input type="text" name="bank_name" :value="old('bank_name')" required />
            </div>
            @error('bank_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="account_name" class="block text-sm font-medium text-gray-900">Nama Pemilik Rekening</label>
            <div class="mt-2">
                <x-admin.input type="text" name="account_name" :value="old('account_name')" required />
            </div>
            @error('account_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="account_number" class="block text-sm font-medium text-gray-900">Nomor Rekening</label>
            <div class="mt-2">
                <x-admin.input type="text" name="account_number" :value="old('account_number')" required />
            </div>
            @error('account_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-x-3">
            <x-admin.button type="submit" variant="primary">
                Simpan
            </x-admin.button>
            <x-admin.button as="a" href="{{ route('admin.bank-accounts.index') }}" variant="secondary">
                Batal
            </x-admin.button>
        </div>
    </form>
</div>
@endsection
