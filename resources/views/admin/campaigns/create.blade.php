@extends('layouts.admin')

@section('title', 'Buat Campaign')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold tracking-tight text-gray-900">Buat Campaign</h1>

    <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium text-gray-900">Judul Campaign</label>
            <div class="mt-2">
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
            </div>
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-900">Deskripsi</label>
            <div class="mt-2">
                <textarea name="description" id="description" rows="5"
                          class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">{{ old('description') }}</textarea>
            </div>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="target_amount" class="block text-sm font-medium text-gray-900">Target Dana (Rp)</label>
            <div class="mt-2">
                <input type="number" name="target_amount" id="target_amount" value="{{ old('target_amount') }}" required min="1000" step="1"
                       class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
            </div>
            @error('target_amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="deadline" class="block text-sm font-medium text-gray-900">Deadline</label>
            <div class="mt-2">
                <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}" required
                       class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:outline-indigo-600 sm:text-sm">
            </div>
            @error('deadline') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-900">Gambar (Opsional)</label>
            <div class="mt-2">
                <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>
            <p class="mt-1 text-xs text-gray-500">JPG/PNG, maksimal 2MB.</p>
            @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-x-3">
            <button type="submit"
                    class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                Simpan
            </button>
            <a href="{{ route('admin.campaigns.index') }}"
               class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
