<x-filament::widget>
    <x-filament::section>
        <div class="flex flex-col gap-6">
            <!-- Stats & Info Cards -->
            <div class="grid gap-4 md:grid-cols-4">
                <!-- Cache Driver Card -->
                <div class="bg-gray-800 rounded-lg p-4 shadow-md">
                    <h3 class="text-sm font-medium text-gray-400">Cache Driver</h3>
                    <div class="mt-2 text-2xl font-bold text-white">{{ $this->getCacheDriverInfo()['driver'] }}</div>
                    <div class="mt-1 text-xs text-amber-400 flex items-center">
                        <x-heroicon-m-cube class="mr-1 h-4 w-4" />
                        Type: {{ $this->getCacheDriverInfo()['type'] }}
                    </div>
                </div>

                <!-- Cache Size Card -->
                <div class="bg-gray-800 rounded-lg p-4 shadow-md">
                    <h3 class="text-sm font-medium text-gray-400">Cache Size</h3>
                    <div class="mt-2 text-2xl font-bold text-white">{{ $this->getCacheSizeInfo()['size'] }}</div>
                    <div class="mt-1 text-xs text-blue-400 flex items-center">
                        <x-heroicon-m-document class="mr-1 h-4 w-4" />
                        {{ $this->getCacheSizeInfo()['entries'] }} entries
                    </div>
                </div>

                <!-- Cache Actions Card -->
                <div class="bg-gray-800 rounded-lg p-4 shadow-md">
                    <h3 class="text-sm font-medium text-gray-400">Cache Actions</h3>
                    <div class="mt-2 text-xl font-semibold text-white flex space-x-2">
                        <button 
                            wire:click="$dispatch('clear-application-cache')" 
                            class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white text-xs rounded transition"
                        >
                            Clear Cache
                        </button>
                        <button 
                            wire:click="$dispatch('clear-config-cache')" 
                            class="px-2 py-1 bg-amber-600 hover:bg-amber-700 text-white text-xs rounded transition"
                        >
                            Config
                        </button>
                    </div>
                    <div class="mt-1 text-xs text-red-400 flex items-center">
                        <x-heroicon-m-trash class="mr-1 h-4 w-4" />
                        Clear application caches
                    </div>
                </div>

                <!-- Environment Card -->
                <div class="bg-gray-800 rounded-lg p-4 shadow-md">
                    <h3 class="text-sm font-medium text-gray-400">Environment</h3>
                    <div class="mt-2 text-2xl font-bold text-white capitalize">{{ $this->getEnvironmentInfo()['name'] }}</div>
                    <div class="mt-1 text-xs text-amber-400 flex items-center">
                        <x-heroicon-m-cog class="mr-1 h-4 w-4" />
                        {{ $this->getEnvironmentInfo()['debug'] }}
                    </div>
                </div>
            </div>

            <!-- Additional Action Buttons -->
            <div class="flex space-x-3 pt-2">
                <button 
                    wire:click="$dispatch('clear-route-cache')" 
                    class="px-3 py-1.5 bg-gray-700 hover:bg-gray-600 text-white text-sm rounded transition flex items-center"
                >
                    <x-heroicon-m-map class="mr-1.5 h-4 w-4" />
                    Clear Route Cache
                </button>
                <button 
                    wire:click="$dispatch('clear-view-cache')" 
                    class="px-3 py-1.5 bg-gray-700 hover:bg-gray-600 text-white text-sm rounded transition flex items-center"
                >
                    <x-heroicon-m-eye class="mr-1.5 h-4 w-4" />
                    Clear View Cache
                </button>
            </div>
        </div>
    </x-filament::section>
</x-filament::widget>
