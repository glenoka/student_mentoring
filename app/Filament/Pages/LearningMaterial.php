<?php

namespace App\Filament\Pages;

use App\Models\LearningMaterial as ModelsLearningMaterial;
use Filament\Pages\Page;
use Livewire\WithPagination;

class LearningMaterial extends Page
{
    use WithPagination;
    protected string $view = 'filament.pages.learning-material';
    public $materials;
     public int | string $perPage = 10;
       public ?string $search = '';

        public function updatedSearch(): void
    {
        $this->resetPage();
    }

   public function getMaterialsProperty()
    {
         return ModelsLearningMaterial::query()
                ->with('teacher')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate($this->perPage);
    }
}
