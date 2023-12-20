<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required',
        ])->validate();

        Tag::updateOrCreate(['id' => $request->id], $validated);
    }

    /**
     * Remove the specified resource from storage.
     * @param Tag $tag
     * @return void
     */
    public function destroy(Tag $tag): void
    {
        $tag->delete();
    }
}
