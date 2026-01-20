<x-app-layout>
    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-xl font-bold mb-6">
                Search results for “{{ $query }}”
            </h2>

            @forelse($posts as $post)
                <x-post-item :post="$post" />
            @empty
                <p class="text-gray-500">No posts found.</p>
            @endforelse

            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
