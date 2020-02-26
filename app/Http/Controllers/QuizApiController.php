<?php

namespace App\Http\Controllers;

use App\Quiz;
use Illuminate\Http\Request;

class QuizApiController extends Controller
{
    public function getQuizzes($quiz_id = null)
    {
        if ($quiz_id == null) {
            return Quiz::with('questions')->get();
        } else {
            return Quiz::with('questions')->findOrFail($quiz_id);
        }
    }

}
