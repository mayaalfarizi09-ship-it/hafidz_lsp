<a href="{{ route('article', $article->slug) }}" class="flex gap-4 bg-blue-100 p-4 items-center hover:bg-blue-100/80">
    @if ($article->image)
        <img src="{{ asset('storage/' . $article->image) }}" alt="" class="w-32 h-24 object-cover shrink-0">
    @endif
    <div>
        <div class="text-blue-700 font-bold">{{ $article->title }}</div>
        <p class="text-sm text-blue-900/90 mt-1">{{ \Illuminate\Support\Str::limit($article->body, 110) }}</p>
    </div>
</a>
