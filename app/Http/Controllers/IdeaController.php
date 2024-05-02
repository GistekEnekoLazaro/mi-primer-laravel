<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IdeaController extends Controller
{

    private array $rules = [
        'titulo' => 'required|string|max:100',
        'descripcion' => 'required|string|max:300',
    ];

    private array $errorMessages = [
        'required' => 'El campo :attribute es obligatorio.',
        'string' => 'Caracteres no validos.',
        'max' => 'El campo :attribute no debe ser mayor a :max caracteres.',
    ];

    public function index(): View
    {
        $ideas = Idea::get();
        return view('ideas.index', ['ideas' => $ideas]);
    }

    public function create(): View
    {
        return view('ideas.create_or_edit');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules, $this->errorMessages);

        Idea::create([
            'user_id' => auth()->user()->id, //$request->user()->id
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'],
        ]);

        session()->flash('message', 'Idea creada correctamente');

        return redirect()->route('idea.index');
    }

    public function edit(Idea $idea): View
    {
        return view('ideas.create_or_edit')->with('idea', $idea);
    }

    public function update(Request $request, Idea $idea): RedirectResponse
    {
        $validated = $request->validate($this->rules, $this->errorMessages);

        $idea->update($validated);

        session()->flash('message', 'Idea editada correctamente');

        return redirect(route('idea.index'));
    }

    public function show(Idea $idea): View
    {
        return view('ideas.show')->with('idea', $idea);
    }

    public function delete(Idea $idea): RedirectResponse
    {
        $idea->delete();

        session()->flash('message', 'Idea borrada correctamente');

        return redirect()->route('idea.index');
    }
}
