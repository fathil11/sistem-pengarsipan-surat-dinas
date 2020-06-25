<?php

namespace App\Services\Mail;

use App\MailPriority;
use App\Http\Requests\MailComponentsRequest;

class MailComponentPriorityService
{
    /** Store User Department */
    public static function store(MailComponentsRequest $request)
    {
        // Validate Form
        $request->validated();

        // Create UserDepartment
        MailPriority::create([
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
        $mail_priority = MailPriority::findOrFail($id);

        // Update UserDepartment
        $mail_priority->update([
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
        $mail_priority = MailPriority::findOrFail($id);
        $mail_priority->delete();
        return response(200);
    }
}
