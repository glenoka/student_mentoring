<?php

namespace App\Filament\Parent\Pages;

use App\Models\Parents;
use App\Models\Student;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;


class StudentView extends Page implements HasSchemas
{
     use InteractsWithSchemas;

    protected string $view = 'filament.parent.pages.student-view';

  public array $data = [];
  public $student;
    public function mount(): void
    {
        $parentID = Parents::where('user_id', Auth::user()->id)->first();

        $this->student = Student::where('parent_id', $parentID->id)
            ->first(); 
           
           

        // Fill data as array for the schema
        $this->data = $this->student?->toArray() ?? [];
    }

    public function studentDetail(Schema $schema): Schema
    {
        
       return $schema
        ->record($this->student)
        ->components([
            TextEntry::make('name'),
            TextEntry::make('class'),
        ]);
    }

    
}
