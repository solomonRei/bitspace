<?php

namespace App\Http\Controllers;

use App\Contracts\PlatformContract as PlatformService;
use App\Models\Event;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/*
 * KEY DqYkwUPfRTqZdOJTtKS91g
 * Secret 5fsnRxf90c1wSD5WsuDkf9j98a7lftijQ21L
 * IM Chat eyJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJxX2t4YzdvaFRyYUlIcFZxUGx4WXFBIn0.-u_IGn23rTnKtJH_vbO5k1ptDPz1cbxUcVfNGy1lGcU
 * JWT token eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6IkRxWWt3VVBmUlRxWmRPSlR0S1M5MWciLCJleHAiOjE2MjAyODUwMjgsImlhdCI6MTYxOTY4MDIyOH0.ymm27XCC89xNb0dJum8b8HQ2YklK_xCB5nXpzUzKtFA
 */

class FullCalenderController extends Controller
{
    protected $platformService;
    protected $userService;

    public function __construct(PlatformService $platformService, UserService $userService)
    {
        $this->platformService = $platformService;
        $this->userService = $userService;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            $user = $this->userService->getAuthenticated();
            $data = Event::where('user_id', $user->id)
                ->whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);
            return response()->json($data);
        }
        return view('frontend.profile.calendar');

    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            $user = $this->userService->getAuthenticated();
            if ($request->type == 'add') {

                $title = $request->title;

                if (isset($request->action)) $action = $request->action;
                else $action = '';

                if ($action == 'plan') {

                    $lecturer = $this->userService->getUser($request->user_id);

                        $data = array();
                        $title = "Запланирован урок";
                        $data['topic'] = "Урок";
                        $data['start_date'] = date("Y-m-d h:i:s", strtotime($request->start));
                        $data['duration'] = 45;
                        $data['type'] = 2;
                        $data['password'] = Str::random(8);

                    if ($conference = $this->platformService->create($data, $request->user_id)) toastr()->success(__('custom.conference_success'));
                    else {
                        return response()->json(['error' => true]);
                    }

                    Event::create([
                        'user_id' => $request->user_id,
                        'conference_id' => $conference->id,
                        'type' => 'system',
                        'title' => $title ?? 'Новый урок',
                        'start' => $request->start,
                        'end' => $request->end
                    ]);

                }

                $event = Event::create([
                    'user_id' => $user->id,
                    'conference_id' =>  $action == 'plan' ? $conference->id : null,
                    'type' => $action == 'plan' ? 'system' : 'user',
                    'title' => $title,
                    'start' => $request->start,
                    'end' => $request->end
                ]);

                return response()->json($event);
            }

            if ($request->type == 'update') {
                $event = Event::find($request->id);
                if ($event->type === 'user')
                    $event->update([
                        'title' => $request->title,
                        'start' => $request->start,
                        'end' => $request->end
                    ]);
                else $event = [
                    'error' => true
                ];


                return response()->json($event);
            }

            if ($request->type == 'delete') {
                $event = Event::find($request->id);
                if ($event->type === 'user') $event->delete();
                else $event = [
                    'error' => true
                ];
                return response()->json($event);
            }
        }
    }
}
