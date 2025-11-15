<?php

namespace App\Http\Controllers;

use App\Models\PosyanduSchedule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = PosyanduSchedule::orderBy('event_date')->get();

        return view('schedules.index', compact('schedules'));
    }

    public function store(Request $request)
    {
        $data = $this->validatePayload($request);

        PosyanduSchedule::create($data);

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function update(Request $request, PosyanduSchedule $schedule)
    {
        $data = $this->validatePayload($request);

        $schedule->update($data);

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(PosyanduSchedule $schedule)
    {
        $schedule->delete();

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    private function validatePayload(Request $request): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'nullable|string|max:500',
            'event_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'location' => 'nullable|string|max:150',
            'is_published' => 'nullable|boolean',
        ]);

        if ($request->filled('start_time') && $request->filled('end_time')) {
            $start = Carbon::createFromFormat('H:i', $request->input('start_time'));
            $end = Carbon::createFromFormat('H:i', $request->input('end_time'));

            if ($end->lessThanOrEqualTo($start)) {
                throw ValidationException::withMessages([
                    'end_time' => 'Jam selesai harus lebih besar dari jam mulai.',
                ]);
            }
        }

        $data['is_published'] = $request->boolean('is_published', true);

        return $data;
    }
}
