<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::where('is_published', true);

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Upcoming events
        if ($request->filled('period') && $request->period == 'upcoming') {
            $query->where('start_date', '>=', now());
        }

        $events = $query->orderBy('start_date', 'asc')->paginate(6);

        $categories = Event::where('is_published', true)
                          ->select('category')
                          ->distinct()
                          ->pluck('category');

        $types = Event::where('is_published', true)
                     ->select('type')
                     ->distinct()
                     ->pluck('type');

        return view('member.events.index', compact('events', 'categories', 'types'));
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)
                     ->where('is_published', true)
                     ->firstOrFail();

        $upcomingEvents = Event::where('is_published', true)
                              ->where('id', '!=', $event->id)
                              ->where('start_date', '>=', now())
                              ->orderBy('start_date', 'asc')
                              ->take(3)
                              ->get();

        return view('member.events.show', compact('event', 'upcomingEvents'));
    }
}