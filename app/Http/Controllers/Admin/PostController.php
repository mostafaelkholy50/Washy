<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'content_en' => 'nullable|string',
            'content_ar' => 'nullable|string',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $post = new Post();
        $post->setTranslation('title', 'en', $request->title_en);
        $post->setTranslation('title', 'ar', $request->title_ar);

        if ($request->content_en) {
            $post->setTranslation('content', 'en', $request->content_en);
        }
        if ($request->content_ar) {
            $post->setTranslation('content', 'ar', $request->content_ar);
        }

        $post->published_at = $request->published_at;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $destinationPath = public_path('images/posts');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $this->resizeImage($request->image, $destinationPath, $imageName, 700, 400);

            $post->image = 'images/posts/' . $imageName;
        }

        $post->save();

        return redirect()->route('admin.posts.index')->with('success', 'تم إضافة المقال بنجاح.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'content_en' => 'nullable|string',
            'content_ar' => 'nullable|string',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        $post->setTranslation('title', 'en', $request->title_en);
        $post->setTranslation('title', 'ar', $request->title_ar);

        if ($request->content_en) {
            $post->setTranslation('content', 'en', $request->content_en);
        }
        if ($request->content_ar) {
            $post->setTranslation('content', 'ar', $request->content_ar);
        }

        $post->published_at = $request->published_at;

        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $destinationPath = public_path('images/posts');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $this->resizeImage($request->image, $destinationPath, $imageName, 700, 400);

            $post->image = 'images/posts/' . $imageName;
        }

        $post->save();

        return redirect()->route('admin.posts.index')->with('success', 'تم تحديث المقال بنجاح.');
    }

    public function destroy(Post $post)
    {
        if ($post->image && file_exists(public_path($post->image))) {
            unlink(public_path($post->image));
        }
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'تم حذف المقال بنجاح.');
    }
    private function resizeImage($file, $destinationPath, $filename, $targetWidth, $targetHeight)
    {
        if (!extension_loaded('gd')) {
            $file->move($destinationPath, $filename);
            return;
        }

        $extension = $file->extension();
        $sourcePath = $file->path();

        list($width, $height) = getimagesize($sourcePath);

        $newImage = imagecreatetruecolor($targetWidth, $targetHeight);

        switch (strtolower($extension)) {
            case 'jpeg':
            case 'jpg':
                $source = imagecreatefromjpeg($sourcePath);
                break;
            case 'png':
                $source = imagecreatefrompng($sourcePath);
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
                break;
            case 'gif':
                $source = imagecreatefromgif($sourcePath);
                break;
            default:
                // Fallback for unsupported types
                $file->move($destinationPath, $filename);
                return;
        }

        imagecopyresampled($newImage, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        $fullPath = $destinationPath . '/' . $filename;

        switch (strtolower($extension)) {
            case 'jpeg':
            case 'jpg':
                imagejpeg($newImage, $fullPath, 90);
                break;
            case 'png':
                imagepng($newImage, $fullPath);
                break;
            case 'gif':
                imagegif($newImage, $fullPath);
                break;
        }

        imagedestroy($newImage);
        imagedestroy($source);
    }
}
