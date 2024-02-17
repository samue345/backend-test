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
        $parsedUrl = parse_url($redirect->url_destino);
        $urlRedirect = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'];


        return redirect()->to($urlRedirect);


   

   }


  
}
