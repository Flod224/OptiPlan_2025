<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function checkSessionName(Request $request)
{
    $sessionName = $request->query('nom'); 
    $exists = \App\Models\Sessions::where('nom', $sessionName)->exists();

    return response()->json(['exists' => $exists]);
}

}
