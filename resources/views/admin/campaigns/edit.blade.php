@extends('layouts.admin')

@section('title', 'Edit Campaign')

@section('content')
<div class="max-w-2xl">

    <h1 class="text-2xl font-bold tracking-tight text-gray-900">Edit Campaign</h1>

    <form action="{{ route('admin.campaigns.update', $campaign) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-sm font-medium text-gray-900">Judul Campaign</label>
            <div class="mt-2">
                <x-admin.input type="text" name="title" :value="old('title', $campaign->title)" required />
            </div>
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-900">Deskripsi</label>
            <div class="mt-2">
                <x-admin.input type="textarea" name="description" :value="old('description', $campaign->description)" :rows="5" />
            </div>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="target_amount" class="block text-sm font-medium text-gray-900">Target Dana (Rp)</label>
            <div class="mt-2">
                <x-admin.input type="number" name="target_amount" :value="old('target_amount', $campaign->target_amount)" required min="1000" step="1" />
            </div>
            @error('target_amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="deadline" class="block text-sm font-medium text-gray-900">Deadline</label>
            <div class="mt-2">
                <x-admin.input type="date" name="deadline" :value="old('deadline', $campaign->deadline->format('Y-m-d'))" required />
            </div>
            @error('deadline') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-900">Gambar Saat Ini</label>
            <div class="mt-2">
                @if($campaign->image_path)
                    <img src="{{ Storage::disk('public')->url($campaign->image_path) }}" alt="{{ $campaign->title }}"
                         class="h-32 w-auto rounded-md object-cover">
                @else
                    <p class="text-sm text-gray-500">Tidak ada gambar.</p>
                @endif
            </div>
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-900">Ganti Gambar (Opsional)</label>
            <div class="mt-2">
                <x-admin.input type="file" name="image" accept="image/jpeg,image/png,image/jpg" />
            </div>
            <p class="mt-1 text-xs text-gray-500">JPG/PNG, maksimal 2MB. Biarkan kosong jika tidak ingin mengganti.</p>
            @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-x-3">
            <x-admin.button as="button" variant="primary" type="submit">
                Simpan
            </x-admin.button>
            <x-admin.button as="a" variant="secondary" href="{{ route('admin.campaigns.index') }}">
                Batal
            </x-admin.button>
        </div>
    </form>
</div>
@endsection
