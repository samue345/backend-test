<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RedirectLog;
use App\Models\Redirect;

class RedirectController extends Controller
{
   public function createRedirect(Request $request, Redirect $redirect)
   {
      
        $request_log = new RedirectLog;

        $request_log->redirect_id = $redirect->id;
        $request_log->ip_request = $request->ip();
        $request_log->user_agent = $request->userAgent();
        $request_log->header_refer = $request->headers->get('referer');
        $request_log->date_access = now();
        $request_log->save();
        

        $parsed_redirect_url = parse_url($redirect->url_destino);
    
        $merged_query_params = array_merge(
            isset($parsed_redirect_url['query']) ? parse_str($parsed_redirect_url['query']) : [],
            $request->query() ?? []
        );
    
        $filtered_query_Params = array_filter($merged_query_params, function ($value) {
            return $value !== null && $value !== '';
        });
    
        $urlRedirect = $parsed_redirect_url['scheme'] . '://' . $parsed_redirect_url['host'] . $parsed_redirect_url['path'];
        
        if (!empty($filtered_query_Params)) 
            $urlRedirect .= '?' . http_build_query($filtered_query_Params);
        
    

        return redirect()->to($urlRedirect);


   

   }


  
}
