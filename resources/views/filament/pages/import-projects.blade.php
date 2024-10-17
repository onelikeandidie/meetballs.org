<x-filament-panels::page>
    <x-filament::card>
        <x-forms.label for="fileContent">
            Parse Projects
        </x-forms.label>
        <x-forms.input.textarea id="fileContent" name="fileContent"
                                rows="20" wire:model="fileContent"
                                placeholder="## Projects
-[Session](example.com) - Description _#hashtag_"/>
        <div class="mt-2">
            <x-filament::button wire:click="parseProjects" wire:disabled="{{ empty($fileContent) }}">
                Parse Projects
            </x-filament::button>
            @if($projectsParsed)
                <x-filament::button wire:click="importProjects" color="success">
                    Import {{ $projectsParsed }} Projects
                </x-filament::button>
            @endif
        </div>
    </x-filament::card>
</x-filament-panels::page>
