<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $id = (int)Auth::id();
            $userId = User::tryChangePassword($id, $request->input());

            if (!$userId) {
                $request->session()->flash('alerts', [
                    'danger' => __('Błąd przy zmianie ustawień!')
                ]);
            }

            if ($userId) {
                $request->session()->flash('alerts', [
                    'primary' => __('Ustawienia zostały pomyślnie zapisne')
                ]);

                return redirect()->route('settings');
            }
        }

        return view('pages.settings');
    }
}
