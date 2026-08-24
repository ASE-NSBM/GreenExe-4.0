@extends('layouts.admin')

@section('title', 'Content')

@section('content')
    <h1 class="font-display text-2xl font-bold text-white">Content</h1>
    <p class="mt-1 text-sm text-light-gray/60">
        Manage competition information, Smart Green City sections and organiser copy (FR-68 to FR-70).
    </p>

    <section class="mt-8">
        <h2 class="font-display text-lg font-semibold text-cyan-tech">Competition information</h2>
        <div class="mt-4 space-y-4">
            @forelse ($competition as $item)
                <form method="POST" action="{{ route('admin.content.update') }}" class="gx-card space-y-3">
                    @csrf
                    <input type="hidden" name="type" value="competition">
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <p class="text-xs uppercase tracking-wider text-light-gray/40">{{ Str::headline($item->section) }}</p>
                    <input name="title" type="text" class="gx-input" value="{{ $item->title }}" required maxlength="255">
                    <textarea name="body" rows="4" class="gx-input" required>{{ $item->body }}</textarea>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 text-sm text-light-gray/70">
                            <input name="is_published" type="checkbox" value="1" class="h-4 w-4 rounded border-white/20 bg-dark-navy" @checked($item->is_published)>
                            Published
                        </label>
                        <button type="submit" class="gx-btn-primary">Save</button>
                    </div>
                </form>
            @empty
                <p class="text-light-gray/60">No competition sections seeded yet.</p>
            @endforelse
        </div>
    </section>

    <section class="mt-10">
        <h2 class="font-display text-lg font-semibold text-cyan-tech">Smart Green City content</h2>
        <div class="mt-4 space-y-4">
            @forelse ($smartCity as $item)
                <form method="POST" action="{{ route('admin.content.update') }}" class="gx-card space-y-3">
                    @csrf
                    <input type="hidden" name="type" value="smart_city">
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <p class="text-xs uppercase tracking-wider text-light-gray/40">{{ Str::headline($item->section) }}</p>
                    <input name="title" type="text" class="gx-input" value="{{ $item->title }}" required maxlength="255">
                    <textarea name="body" rows="3" class="gx-input" required>{{ $item->description }}</textarea>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 text-sm text-light-gray/70">
                            <input name="is_published" type="checkbox" value="1" class="h-4 w-4 rounded border-white/20 bg-dark-navy" @checked($item->is_published)>
                            Published
                        </label>
                        <button type="submit" class="gx-btn-primary">Save</button>
                    </div>
                </form>
            @empty
                <p class="text-light-gray/60">No Smart Green City sections seeded yet.</p>
            @endforelse
        </div>
    </section>
@endsection
