<?php

namespace App\Services\Mail;

use App\MailCorrectionType;
use App\Http\Requests\MailCorrectionTypeRequest;

class MailCorrectionTypeService
{
    /** Show Mail Correction Type List */
    public static function shows()
    {
        $mail_correction_types = MailCorrectionType::all();
        return view('app.mails.settings.correction-type.correction-type-list', compact('mail_correction_types'));
    }

    /** Create Mail Correction Type */
    public static function create()
    {
        return view('app.mails.settings.correction-type.correction-type-add');
    }

    /** Store Mail Correction Type */
    public static function store(MailCorrectionTypeRequest $request)
    {
        // Validate Form
        $request->validated();

        // Create Mail Correction Type
        MailCorrectionType::create([
            'type' => $request->type,
        ]);

        return true;
    }

    /** Edit Mail Correction Type */
    public static function edit($id)
    {
        $mail_correction_type = MailCorrectionType::findOrFail($id);
        return view('app.mails.settings.correction-type.correction-type-edit', compact('mail_correction_type'));
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

        return true;
    }

    /** Delete Mail Correction Type */
    public static function delete($id)
    {
        // Check Mail Correction Type is Exists
        $mail_correction_type = MailCorrectionType::findOrFail($id);
        $mail_correction_type->delete();
        return true;
    }
}
