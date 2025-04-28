<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;

class SettingController extends Controller
{
    public function setFine(Request $request)
    {
        $validated = $request->validate(['fine' => 'required|numeric']);
        Setting::updateOrCreate(
            ['key' => 'fine'],
            ['value' => $validated['fine']]
        );

        return redirect()->back()->with('message_success', 'The fine have been updated!');
    }
}