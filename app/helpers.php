<?php

use Illuminate\Support\Facades\Auth;

function redirectToIndexByRole($adminRoute, $userRoute)
{
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route($adminRoute);
    } else {
        return redirect()->route($userRoute);
    }
}
