<?php

namespace App\Http\Controllers;

use App\Models\Moment;
use Inertia\Inertia;

class MomentController extends Controller
{
    public function index()
    {
        $moments = Moment::published()
            ->newest()
            ->get()
            ->map(fn ($m) => [
                'id'       => $m->id,
                'title'    => $m->title,
                'date'     => $m->date->format('Y-m-d'),
                'body'     => $m->body,
                'category' => $m->category,
            ]);

        return Inertia::render('Moments', [
            'moments' => $moments,
        ]);
    }
}
