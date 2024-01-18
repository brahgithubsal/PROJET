<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
  public function index()
  {
      $courses = Course::with('category')->get();
      return response()->json($courses);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
      $course = new Course([
          'title' => $request->input('title'),
          'description' => $request->input('description'),
        'image' => $request->input('image'),
          'duration' => $request->input('duration'),
          'level' => $request->input('level'),
          'price' => $request->input('price'),
          'nbcopy' => $request->input('nbcopy'),
          'category_id' => $request->input('category_id'),
      ]);
      $course->save();
      return response()->json($course, 201);
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {
      $course = Course::find($id);
      return response()->json($course);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
      $course = Course::find($id);
      $course->update($request->all());
      return response()->json($course, 200);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
      $course = Course::find($id);
      $course->delete();
      return response()->json('Course deleted successfully');
  }
}

