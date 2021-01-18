<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentUpdatePasswordRequest;
use App\Http\Requests\Admin\StuffStoreRequest;
use App\Http\Requests\Admin\StuffUpdateRequest;
use App\Models\Stuff;
use App\User;
use Illuminate\Http\Request;

class StuffController extends Controller
{
    public function index()
    {
        $stuffs = User::role(['stuff', 'admin', 'moderator'])->paginate(15);
        return view('admin.stuff.index', [
            'stuffs' => $stuffs,
        ]);
    }

    public function create()
    {
        return view('admin.stuff.create');
    }

    public function store(StuffStoreRequest $request)
    {
        $result = (new \App\Models\Stuff)->store($request);
        if ($result['success']) {
            return redirect(route('stuff.index'))->withInput()
                ->with(['success' => 'Вы успешно добавили сотрудника']);
        }
        return redirect(route('stuff.create'))->withInput()
            ->with(['error' => $result['message']]);

    }

    public function password_change(StudentUpdatePasswordRequest $request)
    {
        $result = (new \App\Models\Stuff())->password_change($request);
        if ($result['success']) {
            return redirect(route('stuff.index'))
                ->with('success', 'Вы успешно изменили пароль');
        }
        return redirect(route('stuff.index'))
            ->with('error', $result['message']);

    }

    public function deactivate(Request $request)
    {
        $user = User::find($request->stuff_id);
        $user->is_active = false;
        if ($user->save()) {
            return redirect(route('stuff.index'))
                ->with('success', 'Вы успешно деактивировали пользователя');
        }
        return redirect(route('stuff.index'))
            ->with('error', 'Произошла ошибка при деактиваций');

    }

    public function activate(Request $request)
    {
        $user = User::find($request->stuff_id);
        $user->is_active = true;
        if ($user->save()) {
            return redirect(route('stuff.index'))
                ->with('success', 'Вы успешно активировали пользователя');
        }
        return redirect(route('stuff.index'))
            ->with('error', 'Произошла ошибка при активаций');
    }


    public function edit(User $stuff)
    {
        return view('admin.stuff.edit', [
            'stuff' => $stuff,
        ]);
    }

    public function update(StuffUpdateRequest $request, $id)
    {
        $result = (new \App\Models\Stuff)->modify($request, $id);
        if ($result['success']) {
            return redirect(route('stuff.index'))->withInput()
                ->with(['success' => 'Вы успешно изменили сотрудника']);
        }
        return redirect(route('stuff.create'))->withInput()
            ->with(['error' => $result['message']]);

    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect(route('stuff.index'))
            ->with('success', 'Вы успешно удалили пользователя');

    }
}
