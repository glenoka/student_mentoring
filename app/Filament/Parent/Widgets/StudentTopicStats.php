<?php

namespace App\Filament\Parent\Widgets;

use App\Filament\Parent\Pages\MentoringSessionComments;
use App\Models\StudentTopic;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StudentTopicStats extends StatsOverviewWidget
{

protected function getHeading(): ?string
{
    return 'Student Topic Progress';
}

protected function getDescription(): ?string
{
    return 'This shows the progress of student topics based on their mentoring sessions.';
}
     protected function getStats(): array
    {
        $studentTopics = StudentTopic::with('topic','mentoringSessions')
            ->where('student_id', 1)
            ->get();

        $stats = [];

        foreach ($studentTopics as $studentTopic) {

            $stats[] = Stat::make(
                    'Title : '.$studentTopic->topic->title,
                    $studentTopic->mentoringSessions->status=='in_progress' ? 'Process' : 'Finished' 
                   
                )
                ->url(MentoringSessionComments::getUrl([
                        'uuid' => $studentTopic->uuid,
                    ]))
                ->description($studentTopic->mentoringSessions->session_date->diffForHumans())
                ->color($studentTopic->mentoringSessions->status=='in_progress' ? 'warning' : 'success')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->icon('heroicon-o-book-open');
        }

        return $stats;
    }
}
