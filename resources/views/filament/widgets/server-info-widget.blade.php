<x-filament::widget>
    <x-filament::section>
        <div class="space-y-6">
            <!-- Server Overview Header -->
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">Server Health Overview</h2>
                <span class="text-xs text-gray-400">Auto-refreshes every 30s</span>
            </div>
            
            <!-- Resource Utilization Section -->
            <div class="bg-gray-800 rounded-lg p-5">
                <h3 class="text-lg font-medium text-white mb-4 border-b border-gray-700 pb-2">Resource Utilization</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Disk Usage -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-gray-300">Disk Usage</span>
                            <span class="text-amber-400 font-medium">{{ $this->getServerInfo()['diskUsage']['percentage'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-2.5">
                            <div class="bg-amber-400 h-2.5 rounded-full" style="width: {{ $this->getServerInfo()['diskUsage']['percentage'] }}%"></div>
                        </div>
                        <div class="text-xs text-gray-400 mt-1">{{ $this->getServerInfo()['diskUsage']['used'] }} of {{ $this->getServerInfo()['diskUsage']['total'] }}</div>
                    </div>
                    
                    <!-- CPU Usage -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-gray-300">CPU Usage</span>
                            <span class="text-green-400 font-medium">{{ $this->getServerInfo()['cpuUsage'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-2.5">
                            <div class="bg-green-400 h-2.5 rounded-full" style="width: {{ $this->getServerInfo()['cpuUsage'] }}%"></div>
                        </div>
                        <div class="text-xs text-gray-400 mt-1">System average</div>
                    </div>
                    
                    <!-- Memory Usage -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-gray-300">Memory Usage</span>
                            <span class="text-blue-400 font-medium">{{ $this->getServerInfo()['memoryUsage']['percentage'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-700 rounded-full h-2.5">
                            <div class="bg-blue-400 h-2.5 rounded-full" style="width: {{ $this->getServerInfo()['memoryUsage']['percentage'] }}%"></div>
                        </div>
                        <div class="text-xs text-gray-400 mt-1">{{ $this->getServerInfo()['memoryUsage']['used'] }} of {{ $this->getServerInfo()['memoryUsage']['total'] }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Server Information Section -->
            <div class="bg-gray-800 rounded-lg p-5">
                <h3 class="text-lg font-medium text-white mb-4 border-b border-gray-700 pb-2">Server Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Uptime -->
                    <div>
                        <h4 class="text-gray-400 text-sm">Uptime</h4>
                        <div class="text-purple-400 text-lg font-semibold mt-1">{{ $this->getServerInfo()['uptime'] }}</div>
                    </div>
                    
                    <!-- PHP Version -->
                    <div>
                        <h4 class="text-gray-400 text-sm">PHP Version</h4>
                        <div class="text-green-400 text-lg font-semibold mt-1">{{ $this->getServerInfo()['phpVersion'] }}</div>
                    </div>
                    
                    <!-- Web Server -->
                    <div>
                        <h4 class="text-gray-400 text-sm">Web Server</h4>
                        <div class="text-blue-400 text-lg font-semibold mt-1">{{ $this->getServerInfo()['webServer'] }}</div>
                    </div>
                    
                    <!-- Operating System -->
                    <div>
                        <h4 class="text-gray-400 text-sm">Operating System</h4>
                        <div class="text-amber-400 text-lg font-semibold mt-1">{{ $this->getServerInfo()['operatingSystem'] }}</div>
                    </div>
                </div>
            </div>
            
            <!-- Database Information Section -->
            <div class="bg-gray-800 rounded-lg p-5">
                <h3 class="text-lg font-medium text-white mb-4 border-b border-gray-700 pb-2">Database Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Database Size -->
                    <div>
                        <h4 class="text-gray-400 text-sm">Database Size</h4>
                        <div class="text-amber-400 text-lg font-semibold mt-1">{{ $this->getServerInfo()['database']['size'] }}</div>
                    </div>
                    
                    <!-- Tables Count -->
                    <div>
                        <h4 class="text-gray-400 text-sm">Total Tables</h4>
                        <div class="text-green-400 text-lg font-semibold mt-1">{{ $this->getServerInfo()['database']['tables'] }}</div>
                    </div>
                    
                    <!-- MySQL Version -->
                    <div>
                        <h4 class="text-gray-400 text-sm">Database Version</h4>
                        <div class="text-blue-400 text-lg font-semibold mt-1">{{ $this->getServerInfo()['database']['version'] }}</div>
                    </div>
                    
                    <!-- Connections -->
                    <div>
                        <h4 class="text-gray-400 text-sm">Active Connections</h4>
                        <div class="text-purple-400 text-lg font-semibold mt-1">{{ $this->getServerInfo()['database']['connections'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament::widget>
