<x-filament::widget>
    <x-filament::section>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-800 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-white">Failed Logins</h3>
                <div class="mt-2 text-3xl font-bold text-red-400">{{ $this->getSecurityData()['failedLogins'] }}</div>
                <div class="mt-1 text-sm text-gray-300">Last 24 hours</div>
            </div>
            
            <div class="bg-gray-800 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-white">Account Lockouts</h3>
                <div class="mt-2 text-3xl font-bold text-yellow-400">{{ $this->getSecurityData()['accountLockouts'] }}</div>
                <div class="mt-1 text-sm text-gray-300">Last 7 days</div>
            </div>
            
            <div class="bg-gray-800 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-white">Security Status</h3>
                <div class="mt-2 text-3xl font-bold {{ $this->getSecurityData()['securityStatus']['status'] === 'ok' ? 'text-green-400' : 'text-yellow-400' }}">
                    {{ $this->getSecurityData()['securityStatus']['status'] === 'ok' ? 'Secure' : 'Warning' }}
                </div>
                <div class="mt-1 text-sm text-gray-300">{{ $this->getSecurityData()['securityStatus']['message'] }}</div>
            </div>
        </div>
        
        <div class="mt-6">
            <h3 class="text-lg font-medium text-white mb-4">Recent Security Events</h3>
            
            <div class="bg-gray-800 rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Type</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">User</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Time</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($this->getSecurityData()['recentEvents'] as $event)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ ucfirst($event['type']) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $event['user'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $event['time'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $event['status'] === 'success' ? 'bg-green-800 text-green-300' : 
                                          ($event['status'] === 'failed' ? 'bg-red-800 text-red-300' : 'bg-yellow-800 text-yellow-300') }}">
                                        {{ ucfirst($event['status']) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-2 text-xs text-gray-400 text-right">
                Last updated: {{ $this->getSecurityData()['lastCheck'] }}
            </div>
        </div>
    </x-filament::section>
</x-filament::widget>
