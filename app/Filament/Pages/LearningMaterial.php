<?php

namespace App\Filament\Pages;

use App\Models\LearningMaterial as ModelsLearningMaterial;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Livewire\WithPagination;
use UnitEnum;

class LearningMaterial extends Page
{
    use WithPagination;
     protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static ?string $navigationLabel = 'Learning Materials';
    protected static string | UnitEnum | null $navigationGroup = 'Learning Resources';

    protected string $view = 'filament.pages.learning-material';
    public $materials;
     public int | string $perPage = 10;
       public ?string $search = '';
        public $type = '';

        public function updatedSearch(): void
    {
        $this->resetPage();
    }
      public function updatedType()
    {
        $this->resetPage();
    }
public function getMaxContentWidth(): ?string
{
    return 'full';
}
   public function getMaterialsProperty()
    {
         return ModelsLearningMaterial::query()
                ->with('teacher')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })

            ->when($this->type, function ($query) {
                $query->where('type', $this->type);
            })
            ->latest()
            ->paginate($this->perPage);
    }
}
