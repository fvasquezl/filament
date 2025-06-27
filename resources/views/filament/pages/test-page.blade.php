<x-filament-panels::page>
    <div>
        <h2>Test Page</h2>
        <p>If you can see this, you have access to the panel!</p>
        
        <div class="mt-4">
            <h3>Your permissions:</h3>
            <ul>
                @foreach(auth()->user()->getAllPermissions() as $permission)
                    <li>{{ $permission->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</x-filament-panels::page>
