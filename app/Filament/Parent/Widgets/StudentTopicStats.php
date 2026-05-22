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
    $studentID=Auth::user()->parent?->students->first()->id;
    $studentTopics = StudentTopic::with('topic', 'mentoringSessions')
        ->where('student_id', $studentID)
        ->get();

    $stats = [];

    /*
    |--------------------------------------------------------------------------
    | ERROR HANDLING 1
    | Tidak ada student topic sama sekali
    |--------------------------------------------------------------------------
    */
    if ($studentTopics->isEmpty()) {

        return [
            Stat::make('No Topic', 'Belum Ada Topic')
                ->description('Siswa belum memiliki topik pembelajaran')
                ->color('gray')
                ->icon('heroicon-o-book-open'),
        ];
    }

    foreach ($studentTopics as $studentTopic) {

       $latestSession = $studentTopic->mentoringSessions;

        /*
        |--------------------------------------------------------------------------
        | ERROR HANDLING 2
        | Tidak ada mentoring session
        |--------------------------------------------------------------------------
        */
        if (!$latestSession) {

            $stats[] = Stat::make(
                    $studentTopic->topic->title,
                    'No Session'
                )
                ->description('Belum ada mentoring session')
                ->color('gray')
                ->icon('heroicon-o-clock');

            continue;
        }

        $stats[] = Stat::make(
                $studentTopic->topic->title,
                $latestSession->status == 'in_progress'
                    ? 'Process'
                    : 'Finished'
            )
            ->description(
                $latestSession->created_at->diffForHumans()
            )
            ->color(
                $latestSession->status == 'in_progress'
                    ? 'warning'
                    : 'success'
            )
            ->url(
                MentoringSessionComments::getUrl([
                    'uuid' => $studentTopic->uuid,
                ])
            )
             ->chart([7, 2, 10, 3, 15, 4, 17])
            ->icon('heroicon-o-book-open');
    }

    return $stats;
}
}
