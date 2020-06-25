<?php

namespace App\Services\Mail;

use App\MailCorrectionType;
use App\Http\Requests\MailCorrectionTypeRequest;

class MailCorrectionTypeService
{
    /** Store Mail Correction Type */
    public static function store(MailCorrectionTypeRequest $request)
    {
        // Validate Form
        $request->validated();

        // Create Mail Correction Type
        MailCorrectionType::create([
            'type' => $request->type,
        ]);

        return response(200);
    }

    /** Update Mail Correction Type */
    public static function update(MailCorrectionTypeRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        // Check Mail Correction Type is Exists
        $mail_correction_type = MailCorrectionType::findOrFail($id);

        // Update Mail Correction Type
        $mail_correction_type->update([
            'type' => $request->type,
        ]);

        return response(200);
    }

    /** Delete Mail Correction Type */
    public static function delete($id)
    {
        // Check Mail Correction Type is Exists
        $mail_correction_type = MailCorrectionType::findOrFail($id);
        $mail_correction_type->delete();
        return response(200);
    }
}
