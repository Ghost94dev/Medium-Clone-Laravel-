<x-app-layout>
 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex">
                    <!--ForPosts-->
                    <div class="flex-1 pr-8">
                        <h1 class="text-5xl">{{ $user->name }}</h1>

                         <div class=" mt-8 text-gray-900">
                            @forelse($posts as $post)                       
                                <x-post-item :post="$post" />
                            @empty
                                <p class="text-center text-gray-500 py-16">No posts found.</p>
                            @endforelse  
                        </div>
                    </div>
                   

                    <!--sideBar-->
                    <x-follow-ctr :user="$user">
                        <x-user-avatar :user="$user" size="w-24 h-24" />
                       <h3>{{ $user->name }}</h3>
                       <p class="text-gray-500">
                        <span x-text="followersCount">
                            </span> followers</p>
                       <p>
                         {{ $user->bio }}
                       </p>
                       @if (auth()->user() && auth()->user()->id !== $user->id)
                           <div class="mt-4">
                               <button class="rounded-full px-4 py-2 text-white font-bold hover:bg-emerald-700"
                               x-text="following ? 'Unfollow' : 'Follow'"
                               :class="following ? 'bg-red-600' : 'bg-emerald-600'"
                               @click="follow()"
                               >
                                   
                               </button>
                        </div> 
                       @endif
                       
                    </x-follow-ctr>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
