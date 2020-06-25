<?php

namespace App\Services\Mail;

use App\MailType;
use App\Http\Requests\MailComponentsRequest;

class MailComponentTypeService
{
    /** Store Mail Type */
    public static function store(MailComponentsRequest $request)
    {
        // Validate Form
        $request->validated();

        // Create Mail Type
        MailType::create([
            'type' => $request->type,
            'code' => $request->code,
            'color' => $request->color,
        ]);

        return response(200);
    }

    /** Update Mail Type */
    public static function update(MailComponentsRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        // Check Mail Type is Exists
        $mail_type = MailType::findOrFail($id);

        // Update Mail Type
        $mail_type->update([
            'type' => $request->type,
            'code' => $request->code,
            'color' => $request->color,
        ]);

        return response(200);
    }

    /** Delete Mail Type */
    public static function delete($id)
    {
        // Check Mail Type is Exists
        $mail_type = MailType::findOrFail($id);
        $mail_type->delete();
        return response(200);
    }
}
