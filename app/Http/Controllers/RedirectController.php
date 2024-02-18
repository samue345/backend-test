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
        $parsed_url_destino = parse_url($redirect->url_destino);

        $existing_query_params = $parsed_url_destino['query'] ?? '';
        parse_str($existing_query_params, $existing_query_params);

        $merged_params = array_merge(
            $existing_query_params,
            array_filter($request->query() ?? [])
        );

        $filter_params = array_filter($merged_params, fn($value) => $value !== null && $value !== '');

        $url_destino = $parsed_url_destino['scheme'] . '://' . $parsed_url_destino['host'] . ($parsed_url_destino['path'] ?? '');

        if (!empty($filter_params)) 
            $url_destino .= '?' . http_build_query($filter_params);
        

        try 
        {

            DB::beginTransaction();
            $this->logRedirectRequest($request, $redirect, $merged_params);
            DB::commit();

        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            throw $e;
        }

        return redirect()->to($url_destino);
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
