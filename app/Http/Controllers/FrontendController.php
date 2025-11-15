<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use App\Models\PosyanduSchedule;

class FrontendController extends Controller
{
    public function index()
    {
        $images = Gallery::all();

        $today = now();
        $currentMonthSchedules = PosyanduSchedule::query()
            ->where('is_published', true)
            ->whereBetween('event_date', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])
            ->orderBy('event_date')
            ->get();

        $schedules = $currentMonthSchedules->isNotEmpty()
            ? $currentMonthSchedules
            : PosyanduSchedule::query()
                ->where('is_published', true)
                ->whereDate('event_date', '>=', $today->toDateString())
                ->orderBy('event_date')
                ->take(5)
                ->get();

        $firstScheduleDate = $schedules->first()?->event_date?->copy()->locale('id');
        $scheduleMonthLabel = $firstScheduleDate
            ? $firstScheduleDate->translatedFormat('F Y')
            : $today->copy()->locale('id')->translatedFormat('F Y');

        return view('posyandu', compact('images', 'schedules', 'scheduleMonthLabel'));
    }
}
