<?php

namespace App\Filament\Pages;

use App\Models\LearningMaterial as ModelsLearningMaterial;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use UnitEnum;

class LearningMaterial extends Page
{
    use WithPagination;
    use InteractsWithActions;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static ?string $navigationLabel = 'Learning Materials';
    protected static string | UnitEnum | null $navigationGroup = 'Learning Resources';

    protected string $view = 'filament.pages.learning-material';
    public $materials;

    public ?ModelsLearningMaterial $selectedMaterial = null;
    public $editModal = false;
    public int | string $perPage = 10;
    public ?string $search = '';
    public $type = '';



    public ?array $data = [
        'title' => '',
        'description' => '',
        'type' => '',
        'url' => '',
        'thumbnail' => null,

    ];


    public function updatedSearch(): void
    {
        $this->resetPage();
    }
    public function updatedType()
    {
        $this->resetPage();
    }


    public function editSchema(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Material Information')
                    ->description('Add a new learning material to the platform')
                    ->icon('heroicon-o-book-open')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Operasi Bilangan Bulat')
                            ->label('Judul Materi')
                            ->prefixIcon('heroicon-o-pencil-square')
                            ->columnSpan(2),

                        Select::make('type')
                            ->required()
                            ->searchable()
                            ->native(false)
                            ->options([
                                'video' => 'Video',
                                'document' => 'Document',
                                'game' => 'Game',
                                'image' => 'Image',
                            ])
                            ->placeholder('Pilih type materi')
                            ->label('Type Materi'),

                        TextInput::make('url')
                            ->required()
                            ->url()
                            ->placeholder('https://example.com')
                            ->prefixIcon('heroicon-o-link')
                            ->label('URL Materi'),

                        Textarea::make('description')
                            ->required()
                            ->rows(5)
                            ->autosize()
                            ->placeholder('Masukkan deskripsi materi...')
                            ->columnSpan(2)
                            ->label('Deskripsi'),

                        FileUpload::make('thumbnail')
                            ->required()
                            ->disk('public')
                            ->directory('thumbnails')
                            ->maxSize(1024)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Format: JPG, PNG, WEBP. Maksimal 2MB')
                            ->columnSpan(2)
                            ->label('Thumbnail Materi'),
                    ])
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('new')
                ->icon(Heroicon::DocumentPlus)
                ->label('Add New Material')
                ->schema([
                    Section::make('Material Information')
                        ->description('Add a new learning material to the platform')
                        ->icon('heroicon-o-book-open')
                        ->schema([
                            TextInput::make('title')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Contoh: Operasi Bilangan Bulat')
                                ->label('Title Material')
                                ->prefixIcon('heroicon-o-pencil-square')
                                ->columnSpan(2),

                            Select::make('type')
                                ->required()
                                ->searchable()
                                ->native(false)
                                ->options([
                                    'video' => 'Video',
                                    'document' => 'Document',
                                    'game' => 'Game',
                                    'image' => 'Image',
                                ])
                                ->placeholder('Pilih type materi')
                                ->label('Type Material'),

                            TextInput::make('url')
                                ->required()
                                ->url()
                                ->placeholder('https://example.com')
                                ->prefixIcon('heroicon-o-link')
                                ->label('URL Material'),

                            Textarea::make('description')
                                ->required()
                                ->rows(5)
                                ->autosize()
                                ->placeholder('Add description...')
                                ->columnSpan(2)
                                ->label('Description'),

                            FileUpload::make('thumbnail')
                                ->required()
                                ->disk('public')
                                ->directory('thumbnails')
                                ->maxSize(1024)
                                ->imagePreviewHeight('200')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->helperText('Format: JPG, PNG, WEBP. Maximum 2MB')
                                ->columnSpan(2)
                                ->label('Thumbnail Material'),
                        ]),
                ])
                ->action(function ($data) {
                    ModelsLearningMaterial::create([
                        'title' => $data['title'],
                        'description' => $data['description'],
                        'type' => $data['type'],
                        'url' => $data['url'],
                        'thumbnail' => $data['thumbnail'],
                        'teacher_id' => Auth::user()->teacher->id,
                    ]);
                    Notification::make()
                        ->title('Learning Material Added')
                        ->success()
                        ->send();
                }),
        ];
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

public function editAction(): Action
{
    return Action::make('edit')
        ->modalHeading('Edit Material')
        ->icon(Heroicon::PencilSquare)
        ->schema([
            TextInput::make('title')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Contoh: Operasi Bilangan Bulat')
                                ->label('Title')
                                ->prefixIcon('heroicon-o-pencil-square')
                                ->columnSpan(2),

                            Select::make('type')
                                ->required()
                                ->searchable()
                                ->native(false)
                                ->options([
                                    'video' => 'Video',
                                    'document' => 'Document',
                                    'game' => 'Game',
                                    'image' => 'Image',
                                ])
                                ->placeholder('Pilih type materi')
                                ->label('Type Material'),

                            TextInput::make('url')
                                ->required()
                                ->url()
                                ->placeholder('https://example.com')
                                ->prefixIcon('heroicon-o-link')
                                ->label('URL Material'),

                            Textarea::make('description')
                                ->required()
                                ->rows(5)
                                ->autosize()
                                ->placeholder('Add description...')
                                ->columnSpan(2)
                                ->label('Description'),

                            FileUpload::make('thumbnail')
                                ->required()
                                ->disk('public')
                                ->directory('thumbnails')
                                ->maxSize(1024)
                                ->imagePreviewHeight('200')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->helperText('Format: JPG, PNG, WEBP. Maximum 2MB')
                                ->columnSpan(2)
                                ->label('Thumbnail Material'),
        ])
        ->fillForm(fn (array $arguments) => ModelsLearningMaterial::find($arguments['material'])->toArray())
        ->action(function (array $data, array $arguments) {
            ModelsLearningMaterial::find($arguments['material'])->update($data);
        });
}

public function deleteAction(): Action
{
    return Action::make('delete')
        ->color('danger')
        ->icon(Heroicon::Trash)
        ->requiresConfirmation()
        ->modalHeading('Delete Material')
        ->modalDescription('Are you sure?')
        ->action(fn (array $arguments) => ModelsLearningMaterial::find($arguments['material'])?->delete());
}

   
}
