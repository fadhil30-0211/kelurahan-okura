<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialPost;
use Illuminate\Http\Request;

class SocialPostController extends Controller
{
    public function index()
    {
        $posts = SocialPost::orderBy('urutan')->get();
        return view('admin.social-post.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|in:instagram,facebook,tiktok',
            'url'      => 'required|url',
            'caption'  => 'nullable|string|max:255',
        ]);

        $validated['urutan'] = SocialPost::max('urutan') + 1;
        $validated['is_active'] = true;

        SocialPost::create($validated);

        return redirect()->route('admin.social-post.index')->with('success', 'Post media sosial berhasil ditambahkan.');
    }

    public function destroy(SocialPost $socialPost)
    {
        $socialPost->delete();
        return back()->with('success', 'Post berhasil dihapus.');
    }
}
