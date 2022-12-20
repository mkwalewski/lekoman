<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Medicines;
use App\Models\MedicinesDoses;
use App\Models\MedicinesHistory;
use Illuminate\Http\Request;

class MedicinesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $doses = MedicinesDoses::getAllActiveCalculated('now');

        return view('pages.dashboard', ['doses' => $doses]);
    }

    public function list()
    {
        $medicines = Medicines::all();

        return view('pages.medicines', ['medicines' => $medicines]);
    }

    public function dose()
    {
        $doses = MedicinesDoses::all();

        return view('pages.doses', ['doses' => $doses]);
    }

    public function take(Request $request)
    {
        $doses = MedicinesDoses::getAllActiveCalculated('now');

        if ($request->isMethod('post')) {
            $medicineHistoryId = MedicinesHistory::tryAdd($request->input());

            if (!$medicineHistoryId) {
                $request->session()->flash('alerts', [
                    'danger' => __('Błąd przy zapisie dawki leku!')
                ]);
            }

            if ($medicineHistoryId) {
                $request->session()->flash('alerts', [
                    'primary' => __('Dawka leku została pomyślnie zapisna')
                ]);
            }

            return redirect()->route('medicines.take');
        }

        return view('pages.take', ['doses' => $doses]);
    }

    public function history()
    {
        $histories = MedicinesHistory::all();

        return view('pages.history', ['histories' => $histories]);
    }

    public function charts(Request $request)
    {
        $year = DateHelper::getCurrentYear();
        $selectedWeek = $request->input('medicines_id') ?? DateHelper::getCurrentWeek();
        $weeksNumber = DateHelper::getNumberOfWeeksByYear($year);
        $weeks = DateHelper::getWeeksByNumber($weeksNumber, $year);
        $weekData = DateHelper::getWeekData($selectedWeek, $year);
        $histories = MedicinesHistory::getHistory($weekData);

        return view('pages.charts', ['histories' => $histories, 'weeks' => $weeks, 'selectedWeek' => $selectedWeek]);
    }

    public function doseUpdate(Request $request, $id)
    {
        $id = (int)$id;
        $medicines = Medicines::all();
        $medicinesDose = MedicinesDoses::find($id);
        $schedules = MedicinesDoses::getAllSchedules();

        if ($request->isMethod('post')) {
            $medicinesDoseId = MedicinesDoses::tryAddOrUpdate($id, $request->input());

            if (!$medicinesDoseId) {
                $request->session()->flash('alerts', [
                    'danger' => __('Błąd przy zapisie dawkowania!')
                ]);
            }

            if ($medicinesDoseId) {
                $request->session()->flash('alerts', [
                    'primary' => __('Dawkowanie zostało pomyślnie zapisne')
                ]);

                return redirect()->route('medicines.dose');
            }
        }

        return view('pages.doses_update', [
            'id' => $id,
            'medicines' => $medicines,
            'medicinesDose' => $medicinesDose,
            'schedules' => $schedules
        ]);
    }

    public function doseDelete(Request $request, $id)
    {
        $id = (int)$id;
        $medicinesDoseId = MedicinesDoses::tryDelete($id);

        if (!$medicinesDoseId) {
            $request->session()->flash('alerts', [
                'danger' => __('Błąd przy usuwaniu dawkowania!')
            ]);
        }

        if ($medicinesDoseId) {
            $request->session()->flash('alerts', [
                'primary' => __('Dawkowanie zostało pomyślnie usunięte')
            ]);
        }

        return redirect()->route('medicines.dose');
    }

    public function historyDelete(Request $request, $id)
    {
        $id = (int)$id;
        $historyId = MedicinesHistory::tryDelete($id);

        if (!$historyId) {
            $request->session()->flash('alerts', [
                'danger' => __('Błąd przy usuwaniu historii!')
            ]);
        }

        if ($historyId) {
            $request->session()->flash('alerts', [
                'primary' => __('Historia zostało pomyślnie usunięte')
            ]);
        }

        return redirect()->route('medicines.history');
    }
}
