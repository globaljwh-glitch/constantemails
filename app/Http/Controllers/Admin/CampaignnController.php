<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignnController extends Controller
{
    public function edit(Campaign $campaign)
    {
        return view('admin.campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $campaign->update([
            'subject' => $request->input('subject'),
            'html_content' => $request->input('html_content'),
            'json_content' => $request->input('json_content'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Campaign saved successfully!'
        ]);
    }

    public function uploadImage(Request $request)
    {
        // GrapesJS can send files under 'files' or 'file'
        $uploadedFile = $request->file('files') ?? $request->file('file');

        // If it's an array of files, grab the first one
        if (is_array($uploadedFile)) {
            $uploadedFile = $uploadedFile[0] ?? null;
        }

        if ($uploadedFile && $uploadedFile->isValid()) {
            $filename = time() . '_' . preg_replace('/\s+/', '_', $uploadedFile->getClientOriginalName());
            $path = $uploadedFile->storeAs('campaign-images', $filename, 'public');

            return response()->json([
                'data' => [
                    [
                        'src' => asset('storage/' . $path),
                        'type' => 'image',
                    ]
                ]
            ]);
        }

        return response()->json(['error' => 'No valid file uploaded.'], 400);
    }
}