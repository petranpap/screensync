<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;

        // Fetch all projects for the user
        $projects = DB::table('projects')
            ->where('user_id', '=', $userId)
            ->get();

        // Fetch screens with related data
        $screens = DB::table('screens as s')
            ->join('project_screens as ps', 's.id', '=', 'ps.screen_id')
            ->join('projects as p', 'p.id', '=', 'ps.project_id')
            ->leftJoin('screen_template as st', 's.id', '=', 'st.screen_id')
            ->leftJoin('templates as t', 't.id', '=', 'st.template_id')
            ->select('s.id as screen_id', 's.name as screen_name', 's.mac_address', 's.active', 's.created_at', 't.name as tname', 'p.id as project_id', 'p.name as pname', 'p.description')
            ->where('p.user_id', '=', $userId)
            ->get();

        // Fetch screens not associated with any project
        $unassignedScreens = DB::table('screens as s')
            ->leftJoin('project_screens as ps', 's.id', '=', 'ps.screen_id')
            ->select('s.id as screen_id', 's.name as screen_name', 's.mac_address', 's.active', 's.created_at')
            ->where('s.user_id', '=', $userId)
            ->whereNull('ps.project_id')
            ->get();

        // Group screens by project_id
        $screensByProject = $screens->groupBy('project_id');

        return view('projects.index', [
            'projects' => $projects,
            'screensByProject' => $screensByProject,
            'unassignedScreens' => $unassignedScreens
        ]);
    }

    public function updateScreenProject(Request $request)
    {
        $screenId = $request->input('screen_id');
        $projectId = $request->input('project_id');

        if ($projectId === null) {
            // Remove the screen from the project
            DB::table('project_screens')
                ->where('screen_id', $screenId)
                ->delete();
        } else {
            // Update the project_screens table
            DB::table('project_screens')
                ->updateOrInsert(
                    ['screen_id' => $screenId],
                    ['project_id' => $projectId]
                );
        }

        return response()->json(['success' => true]);
    }

    public function addScreen(Request $request)
    {
        $projectId = $request->input('project_id');
        $screenName = $request->input('screen_name');
        $macAddress = $request->input('mac_address');

        // Insert the new screen
        $screenId = DB::table('screens')->insertGetId([
            'name' => $screenName,
            'mac_address' => $macAddress,
            'user_id' => auth()->user()->id,
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign the new screen to the project
        DB::table('project_screens')->insert([
            'screen_id' => $screenId,
            'project_id' => $projectId
        ]);

        return redirect()->route('projects.index');
    }
    public function createProject(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        // Insert the new project
        DB::table('projects')->insert([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'address' => $request->input('address'),
            'user_id' => auth()->user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('projects.index');
    }

    public function addProject()
    {
        return view('projects.add');
    }
}

