<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Validator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();

        return TagResource::collection($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagRequest $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'text' => ['required', 'string'],

        ]);

        // return bad request code with error msg
        if ($validator->fails()) {
            return response()
                ->json(['error' => $validator->errors()])
                ->setStatusCode(400);
        }

        $validated = $validator->safe()->only(['text']);

        $tag = Tag::create($validated);

        return new TagResource($tag);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        //
        $validator = Validator::make($request->all(), [
            'text' => ['sometimes', 'string'],
            'questions.*' => ['sometimes', 'exists:questions,id']

        ]);

        // return bad request code with error msg
        if ($validator->fails()) {
            return response()
                ->json(['error' => $validator->errors()])
                ->setStatusCode(400);
        }

        if (isset($request['text']))
        {
            $validated = $validator->safe()->only(['text']);
            $tag->update($validated);
        }

        if (isset($request['questions']))
        {
            $tag->questions()->sync($request['questions']);
        }

        $tag->save();
        return new TagResource($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()
                ->json(['deleted' => true])
                ->setStatusCode(204);
    }
}
