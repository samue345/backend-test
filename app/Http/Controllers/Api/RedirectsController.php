<?php

namespace App\Http\Controllers\Api;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Redirect;
use App\Models\RedirectLog;
use App\Http\Requests\ValidateRedirect;

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

    public function store(ValidateRedirect $request)
    {

           
            $redirect = new Redirect;
            $redirect->url_destino = $request->input('url_destino');
            $redirect->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Redirect created successfully.',
            ], Response::HTTP_CREATED);
    
    }


    public function edit(Redirect $redirect)
    {
        return view('redirects.edit', compact('redirect'));
    }

    public function update(Request $request, Redirect $redirect)
    {

        if($request->status !== null)
         $redirect->status = $request->status;
    
        if($request->url_destino)
         $redirect->url_destino = $request->url_destino;

        $redirect->save();

        return response()->json([
            'status' => 'succces',
        ], Response::HTTP_OK);
    
    }

    public function destroy(Redirect $redirect)
    {
        return $redirect;
        
        if($redirect->status !== 0)
        {
            $redirect->status = 0;
            $redirect->save();
            $redirect->delete();     
        }
        $redirect->save();

    }
    public function showStats(Redirect $redirect)
    {

    
        $stats = RedirectLog::select('id', 'redirect_id', 'ip_request', 'user_agent', 'date_access', 'header_refer')
        ->where('redirect_id', $redirect->id)->with('Redirect')
        ->get();

        $grouped = $stats->groupBy('header_refer');
        $top_referrer = optional($grouped->map->first())->sortByDesc('count')->first();
        $top_referrer = optional($top_referrer)->header_refer;


        $response = [
            [
                'total_accesses' => $stats->count(),
                'unique_ips' => $stats->pluck('ip_request')->unique()->count(),
                'top_referrer' => $top_referrer,
                'accesses_last_10_days' =>  [
                    'date' => now()->addDays(-10)->format('Y-m-d'),
                    'total' => $stats->where('date_access', '>=', now()->addDays(-10)->format('Y-m-d H:i:s'))->count(),
                    'unique' => $stats->where('date_access', '>=', now()->addDays(-10)->format('Y-m-d H:i:s'))->pluck('ip_request')->unique()->count(),
                ],
            ]
        ];

        return response()->json($response, 200, [], JSON_PRETTY_PRINT);
        
    }
    public function showLogs(Redirect $redirect){

        $redirect_log = RedirectLog::where('redirect_id', $redirect->id)
        ->with(['Redirect', 'queryParamsRequests'])
        ->get();

        return response()->json($redirect_log->toArray(), 200, [], JSON_PRETTY_PRINT);

  }
}
