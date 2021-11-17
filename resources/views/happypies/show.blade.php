<x-app-layout>

    @if (auth()->user())
    <menu-show :menu="{{ $menu }}" :auth_user="{{ auth()->user()->id }}"/>
    @else
    <menu-show :menu="{{ $menu }}"/>  
    @endif
    
</x-app-layout>
