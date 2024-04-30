<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IdeaController extends Controller
{
    public function index(): View
    {
        $ideas = Idea::get();
        return view('ideas.index',['ideas' => $ideas]);
    }

    public function create(): View
    {
        return view('ideas.create_or_edit');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:300',
        ]);

        Idea::create([
            'user_id' => auth()->user()->id, //$request->user()->id
            'titulo' => $validated['title'],
            'descripcion' => $validated['description'],
        ]);

        return redirect()->route('idea.index');
    }

    public function edit(Idea $idea): View
    {
        return view('ideas.create_or_edit')->with('idea', $idea);
    }
}
