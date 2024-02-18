<?php

namespace App\Http\Controllers\Api;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Redirect;
use App\Models\RedirectLog;

class RedirectsController extends Controller
{

    public function index()
    {
        $registers_redirects = Redirect::select('id', 'status', 'updated_at', 'created_at',  'url_destino')->get();
        return view('redirects.listagem_redirects', compact('registers_redirects'));
    }

    public function create()
    {
        return view('redirects.create');
    }

    public function store(Request $request)
    {
        $redirect = new Redirect;
        $redirect->url_destino = $request->url_destino;
        $redirect->save();
        return response()->json([
            'status' => 'succces',
        ], Response::HTTP_OK);
    }

    public function show(RedirectLog $redirect)
    {
        return view('redirects.show', compact('redirect'));
    }

    public function edit(RedirectLog $redirect)
    {
        return view('redirects.edit', compact('redirect'));
    }

    public function update(Request $request, RedirectLog $redirect)
    {
        // Lógica para atualizar o registro
    }

    public function destroy(RedirectLog $redirect)
    {
        return $redirect;
        // Lógica para excluir o registro
    }
    public function showStats(Redirect $redirect)
    {

    
        $stats = RedirectLog::select('id', 'redirect_id', 'ip_request', 'user_agent', 'date_access', 'header_refer')
        ->where('redirect_id', $redirect->id)
        ->with('Redirect')
        ->get();

        $grouped = $stats->groupBy('header_refer');
        $top_referrer = optional($grouped->map->first())->sortByDesc('count')->first();
        $top_referrer = optional($top_referrer)->header_refer;



        $accesses_last_10_days = [
            [
               'date' => now()->addDays(-10)->format('Y-m-d'),
               'total' => $stats->where('date_access', '>=', now()->addDays(-10)->format('Y-m-d H:i:s'))->count(),
               'unique' => $stats->where('date_access', '>=', now()->addDays(-10)->format('Y-m-d H:i:s'))->pluck('ip_request')->unique()->count(),
           ],
        ];

        $unique_ips = $stats->pluck('ip_request')->unique()->count();
        $total_accesses = $stats->count();

        return response()->json([
            'total_accesses' => $total_accesses,
            'unique_ips' => $unique_ips,
            'top_referrer' => $top_referrer,
            'accesses_last_10_days' => $accesses_last_10_days,
        ]);
        
    }
    public function showLogs(Redirect $redirect){

        $redirect_log = RedirectLog::where('redirect_id', $redirect->id)->with('Redirect')->first();

        return view('redirects.redirect_logs', compact('redirect_log'));
  }
}
