@extends('layouts.admin')

@section('title', 'Tambah Rekening Bank')

@section('content')
<div class="max-w-2xl space-y-lg">
    <div>
        <h1 class="text-display-lg-mobile font-display-lg text-on-background">Tambah Rekening Bank</h1>
        <p class="mt-2 text-body-md text-on-surface-variant">Tambahkan rekening baru yang akan ditampilkan kepada donatur sebagai tujuan transfer.</p>
    </div>

    <x-admin.card class="p-6 sm:p-8">
        <form action="{{ route('admin.bank-accounts.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="bank_name" class="block text-label-md font-label-md text-on-background">Nama Bank</label>
                <div class="mt-2">
                    <x-admin.input type="text" name="bank_name" :value="old('bank_name')" required />
                </div>
                @error('bank_name') <p class="mt-2 text-label-md text-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="account_name" class="block text-label-md font-label-md text-on-background">Nama Pemilik Rekening</label>
                <div class="mt-2">
                    <x-admin.input type="text" name="account_name" :value="old('account_name')" required />
                </div>
                @error('account_name') <p class="mt-2 text-label-md text-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="account_number" class="block text-label-md font-label-md text-on-background">Nomor Rekening</label>
                <div class="mt-2">
                    <x-admin.input type="text" name="account_number" :value="old('account_number')" required />
                </div>
                @error('account_number') <p class="mt-2 text-label-md text-error">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <x-admin.button type="submit" variant="primary">
                    Simpan
                </x-admin.button>
                <x-admin.button as="a" href="{{ route('admin.bank-accounts.index') }}" variant="secondary">
                    Batal
                </x-admin.button>
            </div>
        </form>
    </x-admin.card>
</div>
@endsection
