<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Inertia\Inertia;
use App\Models\Token;
use Inertia\Response;

class BackController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(): Response
    {
        $tags = Tag::groupBy('type')->orderBy('title')->get();
        $tokens = Token::with('tags')->latest()->get();

        return Inertia::render('Dashboard', compact('tags', 'tokens'));
    }

}
