<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Screen;
use Illuminate\Support\Facades\DB;

class ScreenController extends Controller
{

    public function index()
    {
        $userId = auth()->user()->id;
        $screens = DB::table('screens as s')
            ->leftJoin('screen_template as st', 's.id', '=', 'st.screen_id')
            ->leftJoin('templates as t', 't.id', '=', 'st.template_id')
            ->leftJoin('project_screens as ps', 'ps.screen_id', '=', 's.id')
            ->leftJoin('projects as p', 'p.id', '=', 'ps.project_id')
            ->select('s.id', 's.name', 's.uuid', 's.created_at', 't.name as tname', 's.active', 'p.name as pname')
            ->where('s.user_id', '=', $userId)
            ->distinct()
            ->get();

        // Fetch all projects for the user
        $projects = DB::table('projects')
            ->where('user_id', '=', $userId)
            ->get();
        return view('screens.index', compact('screens','projects'));
    }

    public function registerUUID(Request $request)
    {
        $uuid = $request->input('uuid');

        // Check if the UUID already exists
        $screen = Screen::where('uuid', $uuid)->first();

        if (!$screen) {
            // Register the UUID with default details (can be updated later)
            $screen = DB::table('screens')->insert([
                'uuid' => $uuid,
                'name' => 'Default Screen Name',
                'user_id' => auth()->user()->id
            ]);

            $screen = Screen::where('uuid', $uuid)->first();
        }

        return response()->json(['message' => 'UUID registered', 'screen' => $screen]);
    }

    public function view(Request $request)
    {

        return view('view.index');
    }


    public function fetchdata(Request $request)
    {
        // Get the UUID from the query parameter
        $uuid = $request->input('uuid');

        // Find the screen by UUID
        $screen = Screen::where('uuid', $uuid)->first();


        // Assuming you have a 'content' field in your 'screens' table to store the URL of the video
        $contentUrl = $screen->id; // Replace with actual field if different

        return response()->json(['uuid' => $contentUrl]);
    }
}

