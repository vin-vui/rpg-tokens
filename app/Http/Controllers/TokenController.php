<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Token;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TokenController extends Controller
{

    /**
     * Get the validation rules that apply to the request.
     * @param Request $request
     * @return array
     */
    protected function rules(Request $request): array
    {
        $rules = [
            'img' => $request->id === null ?
                'required|image|max:10240' :
                'nullable',
        ];

        return $rules;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(): Response
    {
        $tokens = Token::with('tags')->get();
        $tags = Tag::all();

        return Inertia::render('Tokens/Index', compact('tokens', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        $validated = $request->validate($this->rules($request));

        if ($request->hasFile('img')) {
            $path = Storage::disk('public')->put('img', $request->file('img'));
            $validated['img'] = '/storage/' . $path;
        }

        $token = Token::updateOrCreate(['id' => $request->id], $validated);
        $token->tags()->sync($request->tags);
    }

    /**
     * Remove the specified resource from storage.
     * @param Token $token
     * @return void
     */
    public function destroy(Token $token): void
    {
        $token->delete();
    }
}
