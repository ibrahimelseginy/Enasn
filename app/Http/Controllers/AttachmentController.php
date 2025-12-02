<?php
namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'entity_type' => 'required|string',
            'entity_id' => 'required|integer',
            'path' => 'required|string',
            'mime' => 'nullable|string'
        ]);
        return Attachment::create($data);
    }
    public function destroy(Attachment $attachment)
    {
        $attachment->delete();
        return response()->noContent();
    }
}
