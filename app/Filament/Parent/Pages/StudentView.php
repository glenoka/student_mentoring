<?php

namespace App\Filament\Parent\Pages;

use App\Models\Parents;
use App\Models\Student;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class StudentView extends Page
{
    protected string $view = 'filament.parent.pages.student-view';

    public $student;
    public function mount(){
        $parentID=Parents::where('user_id',Auth::user()->id)->first();
        $this->student=Student::where('parent_id',$parentID->id)->with('assessments','studentTopics.topic','studentTopics.mentoringSessions.comments')->get();
       
    }
}
