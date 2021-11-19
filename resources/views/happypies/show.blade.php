<x-app-layout>

    @if (auth()->user())
    <menu-show :menu="{{ $menu }}" :auth_user="{{ auth()->user()->id }}" :categories="{{ $categories }}" />
    @else
    <menu-show :menu="{{ $menu }}" :categories="{{ $categories }}"/>  
    @endif
    
</x-app-layout>
