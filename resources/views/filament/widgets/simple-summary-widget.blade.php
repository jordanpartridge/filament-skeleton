<x-filament::widget>
    <x-filament::section>
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-gray-800 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-white">Database Size</h3>
                <div class="mt-2 text-3xl font-bold text-amber-400">{{ $this->getSummaryData()['dbSize'] }} MB</div>
                <div class="mt-1 text-sm text-gray-300">MySQL database size</div>
            </div>
            
            <div class="bg-gray-800 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-white">PHP Version</h3>
                <div class="mt-2 text-3xl font-bold text-green-400">{{ $this->getSummaryData()['phpVersion'] }}</div>
                <div class="mt-1 text-sm text-gray-300">Current PHP version</div>
            </div>
            
            <div class="bg-gray-800 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-white">Laravel Version</h3>
                <div class="mt-2 text-3xl font-bold text-blue-400">{{ $this->getSummaryData()['laravelVersion'] }}</div>
                <div class="mt-1 text-sm text-gray-300">Current framework version</div>
            </div>
        </div>
    </x-filament::section>
</x-filament::widget>
