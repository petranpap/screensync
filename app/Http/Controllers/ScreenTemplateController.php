<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Screen;
use App\Models\Template;

class ScreenTemplateController extends Controller
{
    public function store(Request $request, Screen $screen)
    {
        $screen->templates()->attach($request->template_id, ['image_file' => $request->image_file]);
        return redirect()->back();
    }
}
