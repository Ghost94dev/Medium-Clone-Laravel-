<ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 justify-center">
    <li class="me-2">
        <a href="/" class="{{ 
            request('category') ? 
            'inline-block px-4 py-2.5 hover:text-gray-900 hover:bg-gray-100 rounded-lg' 
            : 'inline-block px-4 py-2.5 text-white bg-blue-600 rounded-lg' }}">All</a>
    </li>
    @foreach ($categories as $category)
        <li class="me-2">
            <a href="{{ route('post.byCategory', $category->id) }}" 
                class= "{{ 
                    Route::currentRouteNamed('post.byCategory') && 
                    request('category')->id == $category->id
                    ? 'inline-block px-4 py-2.5 text-white bg-blue-600 rounded-lg'
                    : 'inline-block px-4 py-2.5 hover:text-gray-900 hover:bg-gray-100 rounded-lg' 
                }}">
                {{ $category->name }}
            </a>
        </li>
    @endforeach