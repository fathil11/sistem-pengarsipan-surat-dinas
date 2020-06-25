<?php

namespace App\Services\Mail;

use App\MailType;
use App\Http\Requests\MailComponentsRequest;

class MailComponentTypeService
{
    /** Store User Department */
    public static function store(MailComponentsRequest $request)
    {
        // Validate Form
        $request->validated();

        // Create UserDepartment
        MailType::create([
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
        $mail_type = MailType::findOrFail($id);

        // Update UserDepartment
        $mail_type->update([
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
        $mail_type = MailType::findOrFail($id);
        $mail_type->delete();
        return response(200);
    }
}
