<x-app-layout>

    @if (auth()->user())
    <menu-list :auth_user="{{ auth()->user()->id }}"/>
    @else
    <menu-list />  
    @endif
    
</x-app-layout>
