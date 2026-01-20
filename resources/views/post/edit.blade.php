<x-app-layout>

    <div class="py-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-4">
                Update Post: <strong class="font-bold">{{ $post->title }}</strong>
            </h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form action="{{ route('post.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!--title-->
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
                        <input type="text" name="title" value="{{ old('title', $post->title) }}" id="title" class="w-full border border-gray-300 rounded-md p-2" required>

                         @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                         @enderror
                    </div>

                    <!--content-->
                    <div class="mb-4">
                        <label for="content" class="block text-gray-700 font-bold mb-2">Content</label>
                        <textarea name="content" id="content" rows="6" class="w-full border border-gray-300 rounded-md p-2" required>{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                    </div>

                    <!--category-->
                    <div class="mb-4">
                        <label for="category" class="block text-gray-700 font-bold mb-2">Category</label>
                        <select name="category_id" id="category" class="w-full border border-gray-300 rounded-md p-2" required>
                            <option value="" class="text-gray-400" disabled selected>Select a category</option> 
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror   
                    </div>
                    
                    @if ($post->imageUrl())
                        <div class="mb-6">
                            <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full h-auto rounded-md">
                        </div>
                    @endif

                    <!--image upload-->
                    <div class="mb-4">
                        <label class="block mb-2.5 text-sm font-medium text-heading" for="file_input">Upload file</label>
                        <input type="file" name="image" id="image" class="cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body" aria-describedby="file_input_help" id="file_input" type="file">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
                        
                        @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror   
                    </div>

                      <!--published At-->
                    <div class="mb-4">
                        <label for="published_at" value="" class="block text-gray-700 font-bold mb-2">Published At</label>
                        <input type="datetime-local" name="published_at"  value="{{ old('published_at', $post->published_at_formatted) }}" id="published_at"  class="w-full border border-gray-300 rounded-md p-2">
                    </div>

                    <div>
                        <x-primary-button type="submit">
                            Update Post
                        </x-primary-button>
                    </div>
                </form>  
            </div>
        </div>
    </div>
</x-app-layout>