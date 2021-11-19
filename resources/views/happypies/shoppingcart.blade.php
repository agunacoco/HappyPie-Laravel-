<x-app-layout>
    @if (auth()->user())
    <shopping-cart :menus="{{ $menus }}" :auth_user="{{ auth()->user()->id }}"/>
    @else
        <shopping-cart />
    @endif
    
</x-app-layout>
