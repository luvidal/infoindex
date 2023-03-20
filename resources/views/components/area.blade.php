@php($class = 'flex flex-col items-center h-96 border-2 border-slate-800 rounded-lg p-2 sm:p-4 md:p-8 min-w-[350px]')

<div {{ $attributes->merge(['class' => $class]) }}>
{{ $slot }}
</div>