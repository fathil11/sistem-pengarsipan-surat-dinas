<?php

namespace App\Services\Mail;

use App\MailPriority;
use App\Http\Requests\MailComponentsRequest;

class MailComponentPriorityService
{
    /** Show Mail Priority List */
    public static function shows()
    {
        $mail_priorities = MailPriority::all();
        return view('app.mails.settings.priority.priority-list', compact('mail_priorities'));
    }

    /** Create Mail Priority */
    public static function create()
    {
        return view('app.mails.settings.priority.priority-add');
    }

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

        return redirect('/surat/pengaturan/prioritas-surat');
    }

    /** Edit Mail Priority */
    public static function edit($id)
    {
        $mail_priority = MailPriority::findOrFail($id);
        return view('app.mails.settings.priority.priority-edit', compact('mail_priority'));
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

        return redirect('/surat/pengaturan/prioritas-surat');
    }

    /** Delete Mail Priority */
    public static function delete($id)
    {
        // Check Mail Priority is Exists
        $mail_priority = MailPriority::findOrFail($id);
        $mail_priority->delete();
        return redirect('/surat/pengaturan/prioritas-surat');
    }
}
