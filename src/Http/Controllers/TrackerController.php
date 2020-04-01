<?php

namespace Sardoj\Clockify\Http\Controllers;

use Carbon\Carbon;
use Sardoj\Clockify\Tracker;
use Uccello\Core\Http\Controllers\Core\Controller;
use Uccello\Core\Models\Domain;
use Uccello\Core\Models\Module;

class TrackerController extends Controller
{
    public function start(Domain $domain, Module $module)
    {
        $tracker = Tracker::create([
            'date_start' => Carbon::now(),
            'time_start' => Carbon::now(),
            'description' => request('description'),
            'domain_id' => $domain->id
        ]);

        return $tracker;
    }
}
