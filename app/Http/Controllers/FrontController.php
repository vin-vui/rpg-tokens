<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Inertia\Inertia;
use App\Models\Token;
use Inertia\Response;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request): Response
    {
        $tokens = Token::with('tags')->withFilter()->inRandomOrder()->get();

        foreach ($tokens as $token) {
            foreach ($token->tags as $tag) {
                $tags[] = $tag->id;
            }
        }

        $tags = Tag::whereIn('id', $tags)->orderBy('title')->get();

        foreach ($tags as $tag) {
            $filteredTokens = Token::with('tags')->withFilter()->whereHas('tags', function ($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            })->get();

            $tag->tokens_count = $filteredTokens->count();
        }

        $selectedTags = request()->input('tags') == null ? [] : request()->input('tags');
        $title = $tokens->count().' tokens found';

        return Inertia::render('Front/Welcome', compact('tokens', 'tags', 'selectedTags', 'title'));
    }

}
