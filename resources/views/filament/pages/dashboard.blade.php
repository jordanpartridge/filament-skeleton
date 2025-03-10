<x-filament-panels::page class="filament-dashboard-page">
    <x-filament-panels::header :actions="$this->getHeaderActions()" :heading="$this->getHeading()">
        <x-slot name="subheading">
            {{ $this->getSubheading() }}
        </x-slot>
    </x-filament-panels::header>

    <div class="grid grid-cols-1 gap-y-8 p-4 md:p-6">
        @if ($this->getVisibleWidgets())
            <div class="grid grid-cols-1 gap-4 lg:gap-8">
                @foreach ($this->getVisibleWidgets() as $widget)
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl overflow-hidden">
                        {{ $widget }}
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-filament-panels::page>
