<?php

namespace App\Filament\Resources\Assessments\Widgets;

use App\Models\Assessments;
use Filament\Widgets\ChartWidget;

class AssessmentCount extends ChartWidget
{
    protected ?string $heading = 'Assessment Count';

    protected function getData(): array
    {
        $data = Assessments::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    return [
        'datasets' => [
            [
                'label' => 'Assessment per Month',
                'data' => $data->values(),
            ],
        ],
        'labels' => $data->keys()->map(fn ($m) => date('F', mktime(0, 0, 0, $m, 1))),
    ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
