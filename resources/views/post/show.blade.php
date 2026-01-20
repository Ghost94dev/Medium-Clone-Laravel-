<x-app-layout>

    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-2xl font-bold mb-4">{{ $post->title }}</h1>
                  <!--profile image-->
                <div class="flex gap-4 mb-4">
                    <x-user-avatar :user="$post->user" />
                    <div>
                            <x-follow-ctr :user="$post->user" class="flex gap-2">  
                                <a href="{{ route('profile.show', $post->user) }}" class="font-bold hover:text-emerald-500">{{ $post->user->name }}</a>
                                 @auth
                                 •
                                    <button
                                    x-text="following ? 'Unfollow' : 'Follow'"
                                    :class="following ? 'text-red-600' : 'text-emerald-600'"
                                    @click="follow()">
                                   </button>
                                @endauth
                                

                            </x-follow-ctr>
                        <div class="flex gap-2 text-gray-500 text-sm">
                            <span class="text-gray-500">
                                {{ $post->readTime() }} min read
                            </span>•
                            <span class="text-gray-500">
                                {{ $post->created_at->format('F j, Y') }}
                            </span>
                        </div>
                    </div>

                                    
                </div>

                <!--Edit and delete buttons-->
                @if ($post->user_id === Auth::id())
                     <div class="py-4 mt-8 border-t border-gray-200">
                    <x-primary-button href="{{ route('post.edit', $post->slug) }}">
                        Edit Post
                    </x-primary-button>
                <form method="POST" action="{{ route('post.destroy', $post) }}" class="inline">
                        @csrf
                        @method('DELETE')
                    <x-danger-button type="submit">
                        Delete Post
                    </x-danger-button>
                </form>
                </div>
                @endif
               

                <!--clap section-->
                <x-clap-button :post="$post" />

                 <!--image and  content-->
                <div class="mt-8">
                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full h-auto rounded-md">

                    <div class="mb-6 text-body">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                </div>


                <!--comment section---->
                @auth
                    <div class="mt-10">
                        <form action="{{ route('comments.store', $post) }}" method="POST">
                            @csrf

                            <textarea name="body"
                                class="w-full border rounded p-3"
                                rows="3"
                                placeholder="Write a comment..."
                                required></textarea>

                            <button class="mt-2 px-4 py-2 bg-black text-white rounded">
                                Comment
                            </button>
                        </form>
                    </div>
                @endauth

                <div class="mt-8 space-y-6">
                    @foreach ($post->comments as $comment)
                        <div class="flex gap-4">
                            <img src="{{ $comment->user->avatarUrl() }}"
                                class="w-10 h-10 rounded-full">

                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <div>
                                        <a href="{{ route('profile.show', $comment->user->username) }}"
                                        class="font-semibold">
                                            {{ $comment->user->username }}
                                        </a>
                                        <span class="text-sm text-gray-500">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    @if(auth()->id() === $comment->user_id)
                                        <form action="{{ route('comments.destroy', $comment) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-sm text-red-500">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <p class="mt-1 text-gray-700">
                                    {{ $comment->body }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>



                <!--Category-->
                <div class="mt-8 pt-4">
                    <span class="inline-block bg-emerald-100 text-emerald-800 text-xs px-2 py-2 rounded-full font-bold">
                        {{ $post->category->name }}
                    </span>
                </div>  
                <x-clap-button :post="$post" />

                <!--Author info-->
                <div class="text-sm text-gray-500">
                    Posted by {{ $post->user->name }} on {{ $post->created_at->format('F j, Y') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>