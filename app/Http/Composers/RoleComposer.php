<?php

namespace App\Http\Composers;

use Illuminate\View\View;
use App\Models\Role;

class RoleComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->withRoles(Role::all());
    }
}
