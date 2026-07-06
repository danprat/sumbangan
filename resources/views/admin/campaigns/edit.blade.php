@extends('layouts.admin')

@section('title', 'Edit Campaign')

@section('content')
<div class="max-w-3xl space-y-lg">
    <div>
        <h1 class="text-display-lg-mobile font-display-lg text-on-background">Edit Campaign</h1>
        <p class="mt-2 text-body-md text-on-surface-variant">Perbarui informasi campaign dan tampilkan preview gambar dengan layout yang lebih rapi.</p>
    </div>

    <x-admin.card class="p-6 sm:p-8">
        <form action="{{ route('admin.campaigns.update', $campaign) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-label-md font-label-md text-on-background">Judul Campaign</label>
                <div class="mt-2">
                    <x-admin.input type="text" name="title" :value="old('title', $campaign->title)" required />
                </div>
                @error('title') <p class="mt-2 text-label-md text-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-label-md font-label-md text-on-background">Deskripsi</label>
                <div class="mt-2">
                    <x-admin.input type="textarea" name="description" :value="old('description', $campaign->description)" :rows="5" />
                </div>
                @error('description') <p class="mt-2 text-label-md text-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="target_amount" class="block text-label-md font-label-md text-on-background">Target Dana (Rp)</label>
                    <div class="mt-2">
                        <x-admin.input type="number" name="target_amount" :value="old('target_amount', $campaign->target_amount)" required min="1000" step="1" />
                    </div>
                    @error('target_amount') <p class="mt-2 text-label-md text-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="deadline" class="block text-label-md font-label-md text-on-background">Deadline</label>
                    <div class="mt-2">
                        <x-admin.input type="date" name="deadline" :value="old('deadline', $campaign->deadline->format('Y-m-d'))" required />
                    </div>
                    @error('deadline') <p class="mt-2 text-label-md text-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="rounded-xl border border-outline-variant/40 bg-surface-container-low p-4">
                <p class="text-label-md font-label-md text-on-background">Gambar Saat Ini</p>
                <div class="mt-3">
                    @if($campaign->image_path)
                        <img src="{{ Storage::disk('public')->url($campaign->image_path) }}" alt="{{ $campaign->title }}" class="h-40 w-full rounded-xl object-cover sm:w-auto">
                    @else
                        <p class="text-body-md text-on-surface-variant">Tidak ada gambar.</p>
                    @endif
                </div>
            </div>

            <div>
                <label for="image" class="block text-label-md font-label-md text-on-background">Ganti Gambar (Opsional)</label>
                <div class="mt-2">
                    <x-admin.input type="file" name="image" accept="image/jpeg,image/png,image/jpg" />
                </div>
                <p class="mt-2 text-label-sm text-on-surface-variant">JPG/PNG, maksimal 2MB. Biarkan kosong jika tidak ingin mengganti.</p>
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
