<?php

namespace Sardoj\Clockify\Http\Controllers;

use Illuminate\Http\Request;
use Sardoj\Clockify\Tracker;
use Uccello\Core\Http\Controllers\Core\ListController as CoreListController;
use Uccello\Core\Models\Domain;
use Uccello\Core\Models\Module;

class ListController extends CoreListController
{
    /**
     * @inheritDoc
     */
    public function process(?Domain $domain, Module $module, Request $request)
    {
        // Get default view
        $view = parent::process($domain, $module, $request);

        // Add data to the view
        $view->tracker = Tracker::whereNull('date_end')->first();

        return $view;
    }
}
