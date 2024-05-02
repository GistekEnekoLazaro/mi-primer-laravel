<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;


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

    public function index(Request $request): View
    {
        $ideas = Idea::theBest($request->filtro)->myIdeas($request->filtro)->get();
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

        $usuario = auth()?->user();

        session()->flash('message', 'Idea creada correctamente');

        Log::info('[IdeaController] store() - El usuario ['.$usuario?->id.'] '.$usuario?->name.' ha creado la idea con ID '.Idea::latest()->first()->id);

        return redirect()->route('idea.index');
    }

    public function edit(Request $request,Idea $idea)
    {
        if ($request->user()->cannot('update', $idea)) {
            return redirect(route('idea.index', $idea))->with('error', 'No puedes editar una idea que no es tuya');
        }

        return view('ideas.create_or_edit')->with('idea', $idea);
    }

    public function update(Request $request, Idea $idea): RedirectResponse
    {
        if ($request->user()->cannot('update', $idea)) {
            abort(403);
        }

        $validated = $request->validate($this->rules, $this->errorMessages);

        $idea->update($validated);

        session()->flash('message', 'Idea editada correctamente');

        $usuario = auth()?->user();

        Log::info('[IdeaController] update() - El usuario ['.$usuario?->id.'] '.$usuario?->name.' ha editado la idea con ID '.Idea::latest()->first()->id);

        return redirect(route('idea.index'));
    }

    public function show(Idea $idea): View
    {
        return view('ideas.show')->with('idea', $idea);
    }

    public function delete(Request $request,Idea $idea): RedirectResponse
    {
        if ($request->user()->cannot('delete', $idea)) {
            return redirect(route('idea.index', $idea))->with('error', 'No puedes borrar una idea que no es tuya');
        }

        $id_idea = Idea::latest()->first()->id;

        $idea->delete();

        session()->flash('message', 'Idea borrada correctamente');

        $usuario = auth()?->user();

        Log::info('[IdeaController] delete() - El usuario ['.$usuario?->id.'] '.$usuario?->name.' ha borrado la idea con ID '.$id_idea);

        return redirect()->route('idea.index');
    }

    public function syncronizeLikes(Request $request, Idea $idea): RedirectResponse
    {
        if ($request->user()->cannot('like', $idea)) {
            return redirect(route('idea.show', $idea))->with('error', 'No puedes darte me gusta a ti mismo');
        } else {
            $request->user()->ideaLiked()->toggle([$idea->id]);

            $idea->update(['likes' => $idea->users()->count()]);

            return redirect(route('idea.show', $idea));
        }
    }

    public function syncronizeLikesIndex(Request $request, Idea $valiidea, $idea_id): RedirectResponse
    {
        if ($request->user()->cannot('like', $valiidea)) {
            return redirect(route('idea.index', $idea_id))->with('error', 'No puedes darte me gusta a ti mismo');
        } else {
            $idea = Idea::where('id',$idea_id)->first();

            $request->user()->ideaLiked()->toggle([$idea_id]);


            $idea->update(['likes' => $idea->users()->count()]);

            return redirect(route('idea.index'));
        }

    }
}
