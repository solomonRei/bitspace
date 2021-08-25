<?php

namespace App\Http\Controllers;

use App\Services\ConferenceService;
use App\Traits\Languages;
use App\Traits\MetaTags;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use MetaTags, Languages;

    protected $conferenceService;

    public function __construct(ConferenceService $conferenceService)
    {
        $this->conferenceService = $conferenceService;
    }

    public function index()
    {

        $class = 'personal-info-page';

        $events = $this->conferenceService->getAllEventsPaginate('system', 3);

        $this->setMeta(trans('custom.profile_settings'), 'Description');

        return view('frontend.profile.events', compact('class','events'));
    }
}
