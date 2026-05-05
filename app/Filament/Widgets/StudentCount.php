<?php

namespace App\Filament\Widgets;

use App\Models\assessments;
use App\Models\student_topics;
use App\Models\students;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StudentCount extends StatsOverviewWidget
{
    protected function getStats(): array
    {

     $totalAssessment = assessments::whereYear('created_at', now()->year)->count();

        $assessmentThisMonth = assessments::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        return [
            Stat::make('Jumlah Assessment', $totalAssessment.' Assessment')
            ->description($assessmentThisMonth. ' Assessment This Month')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
            Stat::make('Jumlah Student', students::count().' Student')
             ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('warning'),
            Stat::make('Jumlah Mentoring', student_topics::whereYear('created_at', now()->year)->count())
              ->description(student_topics::whereMonth('created_at', now()->month)->count(). ' Mentoring this Month')
            ->chart([10, 2 , 7, 4, 1])
            ->color('success'),
        ];
    }
}
