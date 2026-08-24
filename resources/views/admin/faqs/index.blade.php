@extends('layouts.admin')

@section('title', 'FAQs')

@section('content')
    <h1 class="font-display text-2xl font-bold text-white">FAQs</h1>
    <p class="mt-1 text-sm text-light-gray/60">Manage the questions shown on the public FAQ page (FR-55, FR-67).</p>

    <div class="mt-8 gx-card">
        <h2 class="font-display text-lg font-semibold text-white">Add a question</h2>
        <form method="POST" action="{{ route('admin.faqs.store') }}" class="mt-4 space-y-4">
            @csrf
            <div>
                <label class="gx-label" for="question">Question</label>
                <input id="question" name="question" type="text" class="gx-input" value="{{ old('question') }}" required maxlength="255">
                @error('question') <p class="gx-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="gx-label" for="answer">Answer</label>
                <textarea id="answer" name="answer" rows="3" class="gx-input" required>{{ old('answer') }}</textarea>
                @error('answer') <p class="gx-error">{{ $message }}</p> @enderror
            </div>
            <div class="flex flex-wrap items-end gap-4">
                <div class="w-32">
                    <label class="gx-label" for="sort_order">Order</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" class="gx-input" value="{{ old('sort_order', 0) }}">
                </div>
                <label class="flex items-center gap-2 pb-2 text-sm text-light-gray/70" for="is_published">
                    <input id="is_published" name="is_published" type="checkbox" value="1" class="h-4 w-4 rounded border-white/20 bg-dark-navy" checked>
                    Published
                </label>
                <button type="submit" class="gx-btn-primary">Add FAQ</button>
            </div>
        </form>
    </div>

    <div class="mt-6 space-y-4">
        @forelse ($faqs as $faq)
            <div class="gx-card">
                <form method="POST" action="{{ route('admin.faqs.update', $faq) }}" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    <input name="question" type="text" class="gx-input" value="{{ $faq->question }}" required maxlength="255">
                    <textarea name="answer" rows="3" class="gx-input" required>{{ $faq->answer }}</textarea>
                    <div class="flex flex-wrap items-center gap-4">
                        <input name="sort_order" type="number" min="0" class="gx-input w-28" value="{{ $faq->sort_order }}">
                        <label class="flex items-center gap-2 text-sm text-light-gray/70">
                            <input name="is_published" type="checkbox" value="1" class="h-4 w-4 rounded border-white/20 bg-dark-navy" @checked($faq->is_published)>
                            Published
                        </label>
                        <button type="submit" class="gx-btn-primary">Save</button>
                    </div>
                </form>

                <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-300 hover:underline"
                            onclick="return confirm('Delete this FAQ?')">Delete</button>
                </form>
            </div>
        @empty
            <p class="text-light-gray/60">No FAQs yet.</p>
        @endforelse
    </div>
@endsection
