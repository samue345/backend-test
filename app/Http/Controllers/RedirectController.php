<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RedirectLog;
use App\Models\Redirect;
use App\Models\QueryParamsRequest;
use App\Http\Requests\RequestRedirect;
use Illuminate\Support\Facades\DB;


class RedirectController extends Controller
{
    public function createRedirect(Request $request, Redirect $redirect)
    {
        $parsedRedirectUrl = parse_url($redirect->url_destino);
        $existingQueryParams = [];


        if (isset($parsedRedirectUrl['query'])) 
            parse_str($parsedRedirectUrl['query'], $existingQueryParams);
        
    
        $mergedQueryParams = array_merge(
            $existingQueryParams,
            $request->query() ?? []
        );
    
        $filteredQueryParams = array_filter($mergedQueryParams, function ($value) {
            return $value !== null && $value !== '';
        });
    
        $urlRedirect = $parsedRedirectUrl['scheme'] . '://' . $parsedRedirectUrl['host'] . $parsedRedirectUrl['path'];
    
        if (!empty($filteredQueryParams)) 
            $urlRedirect .= '?' . http_build_query($filteredQueryParams);
        
        try {
            
            DB::beginTransaction();
            $this->logRedirectRequest($request, $redirect, $mergedQueryParams);
            DB::commit();
        } 
        catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        
    

        return redirect()->to($urlRedirect);
    }
    
    private function logRedirectRequest(Request $request, Redirect $redirect, array $queryParameters)
    {
        $request_log = new RedirectLog;

        $request_log->redirect_id = $redirect->id;
        $request_log->ip_request = $request->ip();
        $request_log->user_agent = $request->userAgent();
        $request_log->header_refer = $request->headers->get('referer');
        $request_log->date_access = now();
        $request_log->save();

        if (!empty($queryParameters)) 
        {
            foreach ($queryParameters as $key => $value) 
            {
                $parameter = new QueryParamsRequest();
                $parameter->redirectlog_id = $request_log->id;
                $parameter->key = $key;
                $parameter->value = $value;
                $parameter->save();
            }
        }

    }
    


  
}
