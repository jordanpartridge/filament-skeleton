<x-filament-panels::page class="fi-dashboard-page">
    <x-filament-panels::header :actions="$this->getHeaderActions()" :heading="$this->getHeading()">
        <x-slot name="subheading">
            {{ $this->getSubheading() }}
        </x-slot>
    </x-filament-panels::header>

    <div class="fi-dashboard-widgets grid grid-cols-1 gap-6 lg:grid-cols-12">
        @foreach ($this->getVisibleWidgets() as $widget)
            {{ $widget }}
        @endforeach
    </div>
</x-filament-panels::page>
