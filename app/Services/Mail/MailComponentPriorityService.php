<?php

namespace App\Services\Mail;

use App\MailPriority;
use App\Http\Requests\MailComponentsRequest;

class MailComponentPriorityService
{
    /** Store Mail Priority */
    public static function store(MailComponentsRequest $request)
    {
        // Validate Form
        $request->validated();

        // Create Mail Priority
        MailPriority::create([
            'type' => $request->type,
            'code' => $request->code,
            'color' => $request->color,
        ]);

        return response(200);
    }

    /** Update Mail Priority */
    public static function update(MailComponentsRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        // Check Mail Priority is Exists
        $mail_priority = MailPriority::findOrFail($id);

        // Update Mail Priority
        $mail_priority->update([
            'type' => $request->type,
            'code' => $request->code,
            'color' => $request->color,
        ]);

        return response(200);
    }

    /** Delete Mail Priority */
    public static function delete($id)
    {
        // Check Mail Priority is Exists
        $mail_priority = MailPriority::findOrFail($id);
        $mail_priority->delete();
        return response(200);
    }
}
