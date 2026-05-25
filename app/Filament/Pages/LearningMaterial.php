<?php

namespace App\Filament\Pages;

use App\Models\LearningMaterial as ModelsLearningMaterial;
use BackedEnum;
use Filament\Actions\Action;
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
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;
    protected static ?string $navigationLabel = 'Learning Materials';
    protected static string | UnitEnum | null $navigationGroup = 'Learning Resources';

    protected string $view = 'filament.pages.learning-material';
    public $materials;
    public $selectedMaterial;
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
    public function editMaterial($record)
    {
        
        $material = ModelsLearningMaterial::where('id',$record)->first();
        //dd($material);
        $this->selectedMaterial = $material;
        $this->data = [
            'title' => $material['title'] ?? '',
            'description' => $material['description'] ?? '',
            'type' => $material['type'] ?? '',
            'url' => $material['url'] ?? '',
           'thumbnail' => $material['thumbnail']
        ? [$material['thumbnail']]
        : [],
        ];

        $this->dispatch('open-modal', id: 'edit-material-modal');
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
public function deleteMaterialAction($id): Action
    {
       
        return Action::make('delete')
            ->icon(Heroicon::Trash)
            ->label('Delete Material')
            ->requiresConfirmation()
            ->action(function (array $arguments){
                $data = $arguments['data'];
                dd($data);
                $material = ModelsLearningMaterial::find($data['id']);
                if ($material) {
                    $material->delete();
                    Notification::make()
                        ->title('Learning Material Deleted')
                        ->success()
                        ->send();
                }
            });
    }
public function editMaterialAction(): Action
    {
        return 
            Action::make('edit')
                ->icon(Heroicon::PencilSquare)
                ->label('Edit Material')
                ->schema([
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
                                ->imagePreviewHeight('200')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->helperText('Format: JPG, PNG, WEBP. Maksimal 2MB')
                                ->columnSpan(2)
                                ->label('Thumbnail Materi'),
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
                });
        
    }
    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
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
                                ->imagePreviewHeight('200')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->helperText('Format: JPG, PNG, WEBP. Maksimal 2MB')
                                ->columnSpan(2)
                                ->label('Thumbnail Materi'),
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
}
