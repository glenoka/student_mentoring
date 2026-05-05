<?php

namespace App\Filament\Widgets;

use App\Models\Assessments;
use App\Models\Student;
use App\Models\student_topics;
use App\Models\students;
use App\Models\StudentTopic;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Safe\array;

class StudentCount extends StatsOverviewWidget
{
    protected function getStats(): array
    {

     $totalAssessment = Assessments::whereYear('created_at', now()->year)->count();

        $assessmentThisMonth = Assessments::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        return [
            Stat::make('Jumlah Assessment', $totalAssessment.' Assessment')
            ->description($assessmentThisMonth. ' Assessment This Month')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
            Stat::make('Jumlah Student', Student::count().' Student')
             ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('warning'),
            Stat::make('Jumlah Mentoring', StudentTopic::whereYear('created_at', now()->year)->count())
              ->description(StudentTopic::whereMonth('created_at', now()->month)->count(). ' Mentoring this Month')
            ->chart([10, 2 , 7, 4, 1])
            ->color('success'),
        ];
    }
}
