<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class BlogController extends Controller
{
    public function blogs()
    {
        $blogs = Blog::where('status', 'published')
            ->orderByDesc('date_published')
            ->get();

        return view('blogs.blogs', compact('blogs'));
    }

    public function show(Request $request)
    {
        $blog = Blog::findOrFail($request->blog);

        abort_unless($blog->status === 'published', 404);

        return view('blogs.show', compact('blog'));
    }
    public function index(){
        $author_id = auth()->id();
        $blogs = auth()->user()->blogs()->latest()->get();
        return view('auth.dashboard.blog.index', compact('blogs'));
    }

    /**
     * Create a new draft.
    */
    public function store(){
        $blog = Blog::create([
            'author_id' => auth()->id(),
            'title'     => '',
            'content'   => '',
        ]);

        return redirect()->route('blog.edit', $blog);
    }

    /**
     * Show the editor.
     */
    public function edit(Blog $blog){
        $this->authorize('update', $blog);
        return view('auth.dashboard.blog.edit', compact('blog'));
    }

    /**
     * Autosave.
     */
    public function update(Request $request, Blog $blog)
    {
        \Log::info('BLOG UPDATE REACHED', [
            'blog_id' => $blog->id,
            'user_id' => auth()->id(),
        ]);
        $this->authorize('update', $blog);

        $validated = $request->validate([
            'title' => ['string', 'max:255'],
            'subtitle' => ['string'],
            'content' => ['string'],
            'meta_description' => ['string', 'max:255'],
            'tags' => ['string'],
            // 'image' => [
            //     'required',
            //     'image',
            //     'mimes:jpeg,jpg,png,webp',
            //     'max:5120',
            //     'dimensions:width=1920,height=1080',
            // ],
        ]);
        $validated['date_modified'] = now();
        $validated['date_published'] = now();
        // processing image
        try {
            if ($request->hasFile('image')) {

                if ($blog->image_url) {
                    Storage::disk('public')->delete($blog->image_url);
                }

                $path = $request->file('image')->storeAs(
                    "blogs/{$blog->id}/main_image",
                    'image.' . $request->file('image')->extension(),
                    'public'
                );

                if (!$path) {
                    throw new \Exception('Image could not be stored.');
                }

                $validated['image_url'] = $path;
            }

        } catch (\Throwable $e) {

            return back()->withErrors([
                'image' => $e->getMessage()
            ])->withInput();

        }
        $validated['status'] = "published";
        $blog->update($validated);

        return redirect()
                ->route('blog.edit', $blog->id)
                ->with('success', 'Blog saved successfully.');
    }

    public function uploadContentImage(Request $request, Blog $blog)
    {
        $request->validate([
            'image' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:5120',
            ],
        ]);

        $path = $request->file('image')->store(
            "blogs/{$blog->id}/content_images",
            'public'
        );

        return response()->json([
            'success' => 1,
            'file' => [
                'url' => Storage::url($path),
            ],
        ]);
    }

    public function status(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:draft,published,archived'],
        ]);

        $blog->status = $validated['status'];

        if ($validated['status'] === 'published') {
            $blog->date_published ??= now();
        }

        $blog->date_modified = now();

        $blog->save();

        return back()->with('success', 'Blog status updated successfully.');
    }
    public function destroy(Blog $blog)
    {
        // Delete all files belonging to this blog
        Storage::disk('public')->deleteDirectory(
            "blogs/{$blog->id}"
        );

        // Delete the blog record
        $blog->delete();

        return redirect()
            ->route('blog.index')
            ->with('success', 'Blog deleted successfully.');
    }
}
