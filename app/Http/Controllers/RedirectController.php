<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RedirectLog;

class RedirectController extends Controller
{
   public function createRedirect(Request $request, $redirect)
   {
        $request_log = new RedirectLog;

        $request_log->url_destino = $redirect;
        $request_log->ip_request = $request->ip();
        $request_log->user_agent = $request->userAgent();
        $request_log->header_refer = $request->headers->get('referer');
        $request_log->date_access = now();
        $request_log->save();

       return redirect()->away($redirect);

   }

   public function index(Request $request)
   {
        $redirect_logs = RedirectLog::select('id', 'status', 'updated_at', 'created_at', 'date_access', 'url_destino')->get();

         return view('redirects', compact('redirect_logs'));

   }
}
