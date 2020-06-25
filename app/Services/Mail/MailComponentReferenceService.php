<?php

namespace App\Services\Mail;

use App\MailReference;
use App\Http\Requests\MailComponentsRequest;

class MailComponentReferenceService
{
    /** Store User Department */
    public static function store(MailComponentsRequest $request)
    {
        // Validate Form
        $request->validated();

        // Create UserDepartment
        MailReference::create([
            'type' => $request->type,
            'code' => $request->code,
            'color' => $request->color,
        ]);

        return response(200);
    }

    /** Update User Department */
    public static function update(MailComponentsRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        // Check UserDepartment is Exists
        $mail_reference = MailReference::findOrFail($id);

        // Update UserDepartment
        $mail_reference->update([
            'type' => $request->type,
            'code' => $request->code,
            'color' => $request->color,
        ]);

        return response(200);
    }

    /** Delete User Department */
    public static function delete($id)
    {
        // Check UserDepartment is Exists
        $mail_reference = MailReference::findOrFail($id);
        $mail_reference->delete();
        return response(200);
    }
}
