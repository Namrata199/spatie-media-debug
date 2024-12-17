<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class UserProfile extends Component implements HasForms
{
    use InteractsWithForms, WithFileUploads;

    public array $data = [];

    public $user;

    public array $debugOptions = [];

    public bool $showPrompt = true;

    public $selectedUserId = 1;

    public function mount(): void
    {
        $this->form->fill();

        $this->user = User::find(1);
    }

    public function continueEditing(): void
    {
        $this->showPrompt = false;
        if ($this->selectedUserId) {
            $this->data['data']['media'] = $this->user->getMedia('users')->pluck('uuid', 'uuid')->toArray();
        }
    }

    private function saveMediaFiles(User $user): void
    {
        if (isset($this->data['data']['media']) && is_array($this->data['data']['media'])) {
            foreach ($this->data['data']['media'] as $file) {
                if ($file instanceof TemporaryUploadedFile) {
                    $user->addMediaFromDisk($file->getRealPath())->toMediaCollection('users');
                }
            }
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Image')
                        ->afterValidation(function () {
                            $this->saveMediaFiles($this->user);
                        })
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('data.media')
                                ->multiple()
                                ->collection('images'),
                        ]),
                    Step::make('Info')
                        ->schema([
                            TextInput::make('data.name'),
                        ]),
                ]),

            ])->statePath('data');
    }

    public function save(): void
    {
        $this->validate(); // Validate form data
        $this->user->addMediaFromRequest('data.media') // Example for media upload
            ->toMediaCollection('images');

        session()->flash('success', 'Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
