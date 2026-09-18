<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ImageGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageGalleryController extends Controller
{
    public function index()
    {
        $images = ImageGallery::where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view(
            'frontend.user.account.image-gallery',
            compact('images')
        );
    }

    public function create()
    {
        return view('frontend.user.account.image-gallery-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,gif',
                'max:1024',
            ],
            'caption' => [
                'required',
                'string',
                'max:15',
            ],
        ]);

        // Prevent duplicate caption for the same user
        $captionExists = ImageGallery::where('user_id', auth()->id())
            ->where('caption', $request->caption)
            ->exists();

        if ($captionExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'caption' => 'Caption already exists.',
                ]);
        }

        $file = $request->file('image');

        // Store image
        $path = $file->store('gallery', 'public');

        ImageGallery::create([
            'user_id' => auth()->id(),
            'image'    => $path,
            'size'     => round($file->getSize() / 1024, 2),
            'type'     => $file->getMimeType(),
            'caption'  => $request->caption,
        ]);

        return redirect()
            ->route('user.image-gallery.index')
            ->with('success', 'Image uploaded successfully.');
    }

    public function show(ImageGallery $imageGallery)
    {
        //
    }

    public function edit(ImageGallery $imageGallery)
    {
        //
    }

    public function update(Request $request, ImageGallery $imageGallery)
    {
        //
    }

    public function destroy(ImageGallery $imageGallery)
    {
        //
    }
}