<?php

namespace App\Filament\Parent\Pages;

use App\Models\Parents;
use App\Models\Student;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class MentoringSession extends Page
{
    protected string $view = 'filament.parent.pages.mentoring-session';
    public $student;
    public function mount(){
         $parentID = Parents::where('user_id', Auth::user()->id)->first();

        $this->student = Student::where('parent_id', $parentID->id)
            ->with('assessments.answers.question', 'studentTopics.topic', 'studentTopics.mentoringSessions.comments')
            ->first();
    }
}
