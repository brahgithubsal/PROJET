<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index()
    {
        $lessons = Lesson::with('course')->get(); // Retrieve lessons with their linked courses
        return response()->json($lessons);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lesson = new Lesson([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'resources' => $request->input('resources'),
            'course_id' => $request->input('course_id'),
        ]);
        $lesson->save();
        return response()->json($lesson, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $lesson = Lesson::find($id);
        return response()->json($lesson);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $lesson = Lesson::find($id);
        $lesson->update($request->all());
        return response()->json($lesson, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lesson = Lesson::find($id);
        $lesson->delete();
        return response()->json('Lesson deleted successfully');
    }
}
