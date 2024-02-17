<?php

namespace App\Http\Controllers\Api;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Redirect;

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
    public function showStats(RedirectLog $redirect)
    {
        $total_accesses = $redirect->count();
        $unique_ips = $redirect->distinct('ip_request')->count('ip_request');

        
        return $redirect;        
        /*
        $top_referrer = $redirect->select('header_refer', DB::raw('count(*) as count'))
        ->orderByDesc('count')
        ->groupBy('header_refer')
        ->first();


        $accesses_last_10days = $redirect->select(
            DB::raw('DATE(date_access) as date'),
            DB::raw('count(*) as total'),
            DB::raw('count(DISTINCT ip_request) as unique_ips')
        )
        ->where('date_access', '>=', now()->subDays(10)->toDateString())
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        */

        return response()->json([
            'total_accesses' => $total_accesses,
            'unique_ips' => $unique_ips,
            'top_referrers' => $top_referrer,

        
        ]);
        
        //return view('nome_da_sua_view', compact('total_accesses', 'unique_ips', 'top_referrers', 'accesses_last_10_days'));

        
    
    }
    public function showLogs(RedirectLog $redirect){

        return view('redirect_logs', compact('redirect'));
  }
}
