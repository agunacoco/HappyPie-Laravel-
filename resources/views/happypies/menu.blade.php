<x-app-layout>
    @if (auth()->user())
    <menu-list :menus="{{$menus}}" :auth_user="{{ auth()->user()->id }}"/>
    @else
    <menu-list :menus="{{$menus}}" />  
    @endif
    
</x-app-layout>
