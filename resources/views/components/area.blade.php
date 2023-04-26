@php($container = 'content-center h-96 border-2 border-slate-700 bg-slate-600/25 rounded-lg p-2 sm:p-4 md:p-8 min-w-[350px]')
@props([ 'title' ])
<div  class='{{ $container }} {{ $attributes->get("class") }}'>
    <div class='text-slate-400 text-center uppercase -mt-4 mb-3'>{{ $title }}</div>
    {{ $slot }}
</div>