<?php

namespace App\Http\Controllers;

use App\Models\Seting;
use Illuminate\Http\Request;
use App\Http\Requests\SettingRequest;

class SetingController extends Controller
{
    public function get_all_settings() {
        $all_elements = Seting::all();
        return $all_elements || null;
    }

    public function get_settings($name) {
        $element = Seting::where('name', $name)->first();
        return $element || null;
    }

    public function update_settings(SettingRequest $request, Seting $seting) {
        return $seting->update(
            $request->validated()
        );
    }

    public function create_settings(SettingRequest $request, Seting $seting) {
        return $seting->create(
            $request->validated()
        );
    }
}
