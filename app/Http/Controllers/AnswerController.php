<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Http\Resources\AnswerResource;
use App\Models\Answer;
use App\Models\Question;
use Validator;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $answers = Answer::all();

        return AnswerResource::collection($answers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAnswerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnswerRequest $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'text' => ['required', 'string'],
            'question_id' => ['required', 'exists:questions,id']

        ]);

        // return bad request code with error msg
        if ($validator->fails()) {
            return response()
                ->json(['error' => $validator->errors()])
                ->setStatusCode(400);
        }

        $validated = $validator->safe()->only(['text']);

        $question = Question::find($request['question_id']);


        $answer = $question->answers()->create($validated);

        return new AnswerResource($answer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        return new AnswerResource($answer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnswerRequest  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnswerRequest $request, Answer $answer)
    {
        //
        $validator = Validator::make($request->all(), [
            'text' => ['sometimes', 'string'],

        ]);

        // return bad request code with error msg
        if ($validator->fails()) {
            return response()
                ->json(['error' => $validator->errors()])
                ->setStatusCode(400);
        }

        $validated = $validator->safe()->only(['text']);

        
        $answer->update($validated);

        return new AnswerResource($answer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        $answer->delete();
    }
}
