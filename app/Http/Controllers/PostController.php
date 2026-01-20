<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $query = Post::with(['user', 'media'])
        ->where(function ($query) {
        $query->whereNull('published_at')
              ->orWhere('published_at', '<=', now());
       })


        ->withCount('claps')
        ->latest()->with(['user', 'category']);
 
        if($user){
             // Assuming your following relationship returns User models
           $followingIds = $user->following()->pluck('users.id');

           // Add the user's own ID to see their posts too
           $followingIds->push($user->id);
        
           $query->whereIn('user_id', $followingIds);
        } else {
        // Guest: Show all posts or handle differently
        // If you want guests to see all posts, don't add any where clause
       }

        $posts = $query->simplePaginate(10);
        return view('post.index', compact('posts'));
   }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
         $data = $request->validated();

        //$image =$data['image'];
        //unset($data['image']);
        $data['user_id'] = Auth::id();
       

        //$imagePath = $image->store('posts','public');
        //$data['image'] = $imagePath;

        
        $post= Post::create($data);

        $post->addMediaFromRequest('image')
             ->toMediaCollection('default');

        return redirect()->route('dashboard')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $username, Post $post)
    {

        return view('post.show', compact('post'));  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }
        $categories = Category::all();
        return view('post.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }
        $data = $request->validated();
        
        
        $post->update($data);

        if ($data['image'] ?? false) {
            $post->clearMediaCollection('default');
            $post->addMediaFromRequest('image')
                 ->toMediaCollection('default');
        }
        return redirect()->route('myPosts')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to delete this post.');
        }
        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Post deleted successfully.');
    }

   public function category(Category $category)
    {
        $user = Auth::user();
        
        // Start with posts from this category
        $query = $category->posts()

        ->where(function ($query) {
        $query->whereNull('published_at')
              ->orWhere('published_at', '<=', now());
        })

            
            ->with(['user', 'media'])
            ->withCount('claps')
            ->latest()->with(['category']);

        if ($user) {
            // Get IDs of users that the current user follows
            $followingIds = $user->following()->pluck('users.id');
            
            // Add current user's own ID
            $followingIds->push($user->id);
            
            // Filter posts by these user IDs
            $query->whereIn('user_id', $followingIds);
        }
        // If no user is logged in, guests will see all posts in the category

        $posts = $query->simplePaginate(10);
        return view('post.index', compact('posts'));
    }

    public function myPosts()
    {
        $user = Auth::user();

        $posts = $user->posts()
            ->with(['user', 'media'])
            ->withCount('claps')
            ->latest()
            ->simplePaginate(10);

        return view('post.index', compact('posts'));
    }


    public function search(Request $request)
{
    $query = trim($request->get('q'));

    if (!$query) {
        return redirect()->route('dashboard');
    }

    $posts = Post::query()
        ->where(function ($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%")
              ->orWhere('content', 'LIKE', "%{$query}%")
              ->orWhereHas('user', function ($q2) use ($query) {
                  $q2->where('username', 'LIKE', "%{$query}%");
              });
        })
        ->with(['user', 'category'])
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('post.search', compact('posts', 'query'));
}

}
