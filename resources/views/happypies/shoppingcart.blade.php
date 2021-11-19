<x-app-layout>
    <shopping-cart :menus="{{ $menus }}" :auth_user="{{ auth()->user()->id }}"/>
</x-app-layout>
