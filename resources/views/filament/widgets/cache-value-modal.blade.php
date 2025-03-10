<div class="p-4">
    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">
        Cache Key: {{ $key }}
    </h3>
    
    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg overflow-auto max-h-96">
        @if (is_array($value) || is_object($value))
            <pre class="text-sm text-gray-700 dark:text-gray-300">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
        @else
            <pre class="text-sm text-gray-700 dark:text-gray-300">{{ $value }}</pre>
        @endif
    </div>
</div>
