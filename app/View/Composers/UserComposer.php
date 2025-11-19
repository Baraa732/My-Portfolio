<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\User;

class UserComposer
{
    public function compose(View $view)
    {
        $user = User::where('is_admin', true)->first();
        $view->with('user', $user);
    }
}