<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function list()
    {
        $notifications = Notifications::all();

        return view('pages.notifications', ['notifications' => $notifications]);
    }

    public function update(Request $request, $id)
    {
        $id = (int)$id;
        $notification = Notifications::find($id);
        $schedules = Notifications::getAllSchedules();

        if ($request->isMethod('post')) {
            $notificationId = Notifications::tryAddOrUpdate($id, $request->input());

            if (!$notificationId) {
                $request->session()->flash('alerts', ['danger' => __('Błąd przy zapisie notyfikacji!')]);
            }

            if ($notificationId) {
                $request->session()->flash('alerts', ['primary' => __('Notyfikacja została pomyślnie zapisana')]);

                return redirect()->route('notifications.list');
            }
        }

        return view('pages.notifications_update', [
            'id' => $id,
            'schedules' => $schedules,
            'notification' => $notification,
        ]);
    }

    public function delete(Request $request, $id)
    {
        $id = (int)$id;
        $notificationId = Notifications::tryDelete($id);

        if (!$notificationId) {
            $request->session()->flash('alerts', ['danger' => __('Błąd przy usuwaniu notyfikacji!')]);
        }

        if ($notificationId) {
            $request->session()->flash('alerts', ['primary' => __('Notyfikacja została pomyślnie usunięta')]);
        }

        return redirect()->route('notifications.list');
    }
}
