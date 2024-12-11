<?php

namespace App\Http\Controllers;

use App\Models\Screen;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DashboardController
{
    public function index()
    {
        $userId = auth()->user()->id;

        $company = DB::table('companies as c')
            ->select('c.name')
            ->join('user_company as uc','uc.company_id','=','c.id')
            ->where('uc.user_id','=',$userId)
            ->first();
        // Fetch only active screens for the logged-in user
        $screens = Screen::where('user_id', $userId)
            ->where('active', 1)
            ->get();

        $templatesUsing = DB::table('screens as s')
            ->join('screen_template as st', 's.id', '=', 'st.screen_id')
            ->select('st.template_id')
            ->where('s.user_id', '=', $userId)
            ->where('s.active','=','1')
            ->distinct()
            ->get();

        // Calculate the average updated_at for screen_template based on user_id
        $averageUpdatedAt = DB::table('screen_template as st')
            ->join('screens as s', 'st.screen_id', '=', 's.id')
            ->where('s.user_id', $userId)
            ->avg('st.updated_at');

        $templates = DB::table('templates')
            ->get();
//SELECT * FROM screens s INNER JOIN screen_template st ON s.id=st.screen_id  WHERE s.user_id=14;
        $screensDashboardTables = DB::table('screens as s')
            ->join('screen_template as st', 's.id', '=', 'st.screen_id')
            ->join('templates as t', 't.id', '=', 'st.template_id')
            ->select('s.id','s.name','s.mac_address','s.created_at','t.name as tname','s.active')
            ->where('s.user_id', '=', $userId)
            ->distinct()
            ->get();

        return view('dashboard', compact('screens','templatesUsing','averageUpdatedAt','templates','screensDashboardTables','company'));
    }
}
