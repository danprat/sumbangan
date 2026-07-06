@extends('layouts.admin')

@section('title', 'Buat Campaign')

@section('content')
<div class="max-w-3xl space-y-lg">
    <div>
        <h1 class="text-display-lg-mobile font-display-lg text-on-background">Buat Campaign</h1>
        <p class="mt-2 text-body-md text-on-surface-variant">Isi detail campaign baru dengan tampilan form yang lebih rapi dan konsisten.</p>
    </div>

    <x-admin.card class="p-6 sm:p-8">
        <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-label-md font-label-md text-on-background">Judul Campaign</label>
                <div class="mt-2">
                    <x-admin.input type="text" name="title" :value="old('title')" required />
                </div>
                @error('title') <p class="mt-2 text-label-md text-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-label-md font-label-md text-on-background">Deskripsi</label>
                <div class="mt-2">
                    <x-admin.input type="textarea" name="description" :rows="5" :value="old('description')" />
                </div>
                @error('description') <p class="mt-2 text-label-md text-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="target_amount" class="block text-label-md font-label-md text-on-background">Target Dana (Rp)</label>
                    <div class="mt-2">
                        <x-admin.input type="number" name="target_amount" :value="old('target_amount')" required min="1000" step="1" />
                    </div>
                    @error('target_amount') <p class="mt-2 text-label-md text-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="deadline" class="block text-label-md font-label-md text-on-background">Deadline</label>
                    <div class="mt-2">
                        <x-admin.input type="date" name="deadline" :value="old('deadline')" required />
                    </div>
                    @error('deadline') <p class="mt-2 text-label-md text-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="image" class="block text-label-md font-label-md text-on-background">Gambar (Opsional)</label>
                <div class="mt-2">
                    <x-admin.input type="file" name="image" accept="image/jpeg,image/png,image/jpg" />
                </div>
                <p class="mt-2 text-label-sm text-on-surface-variant">JPG/PNG, maksimal 2MB.</p>
                @error('image') <p class="mt-2 text-label-md text-error">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <x-admin.button as="button" variant="primary" type="submit">
                    Simpan
                </x-admin.button>
                <x-admin.button as="a" variant="secondary" href="{{ route('admin.campaigns.index') }}">
                    Batal
                </x-admin.button>
            </div>
        </form>
    </x-admin.card>
</div>
@endsection
