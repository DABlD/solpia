<?php

namespace App\Http\Composers;

use Illuminate\View\View;

class GlobalComposer
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
        $year_now = now()->format('Y');
        $view->with('cpYear', env('YEAR_MADE') . (env('YEAR_MADE') != $year_now ? ' - ' . $year_now : ''));
    }
}
