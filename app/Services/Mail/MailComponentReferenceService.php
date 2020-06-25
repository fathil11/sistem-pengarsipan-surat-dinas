<?php

namespace App\Services\Mail;

use App\MailReference;
use App\Http\Requests\MailComponentsRequest;

class MailComponentReferenceService
{
    /** Store Mail Reference */
    public static function store(MailComponentsRequest $request)
    {
        // Validate Form
        $request->validated();

        // Create Mail Reference
        MailReference::create([
            'type' => $request->type,
            'code' => $request->code,
            'color' => $request->color,
        ]);

        return response(200);
    }

    /** Update Mail Reference */
    public static function update(MailComponentsRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        // Check Mail Referenceis Exists
        $mail_reference = MailReference::findOrFail($id);

        // Update Mail Reference
        $mail_reference->update([
            'type' => $request->type,
            'code' => $request->code,
            'color' => $request->color,
        ]);

        return response(200);
    }

    /** Delete Mail Reference */
    public static function delete($id)
    {
        // Check Mail Reference is Exists
        $mail_reference = MailReference::findOrFail($id);
        $mail_reference->delete();
        return response(200);
    }
}
