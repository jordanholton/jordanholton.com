<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Moment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MomentController extends Controller
{
    public function index()
    {
        $moments = Moment::newest()
            ->get()
            ->map(fn ($m) => [
                'id'        => $m->id,
                'title'     => $m->title,
                'date'      => $m->date->format('Y-m-d'),
                'body'      => $m->body,
                'category'  => $m->category,
                'published' => $m->published,
            ]);

        return Inertia::render('Admin/Dashboard', [
            'moments' => $moments,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/MomentForm');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => ['required', 'string', 'max:255'],
            'date'      => ['required', 'date'],
            'body'      => ['required', 'string'],
            'category'  => ['required', 'in:personal,professional,milestone'],
            'published' => ['boolean'],
        ]);

        Moment::create($data);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Moment added successfully.');
    }

    public function edit(Moment $moment)
    {
        return Inertia::render('Admin/MomentForm', [
            'moment' => [
                'id'        => $moment->id,
                'title'     => $moment->title,
                'date'      => $moment->date->format('Y-m-d'),
                'body'      => $moment->body,
                'category'  => $moment->category,
                'published' => $moment->published,
            ],
        ]);
    }

    public function update(Request $request, Moment $moment)
    {
        $data = $request->validate([
            'title'     => ['required', 'string', 'max:255'],
            'date'      => ['required', 'date'],
            'body'      => ['required', 'string'],
            'category'  => ['required', 'in:personal,professional,milestone'],
            'published' => ['boolean'],
        ]);

        $moment->update($data);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Moment updated successfully.');
    }

    public function destroy(Moment $moment)
    {
        $moment->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Moment deleted.');
    }
}
