<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ClapController extends Controller
{
    public function clap(Post $post)
    {
        $hasClapped = Auth::user()->hasClapped($post);
        if ($hasClapped) {
            $post->claps()->where('user_id', Auth::id())->delete();
        } else {
            $post->claps()->create([
                'user_id' => Auth::id(),
            ]);
        }
        return response()->json(['clapsCount' => $post->claps()->count()], 200);
    }
}
