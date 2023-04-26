<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1'/>
        <title>Demo :: InfoIndex</title>
        <link rel='icon' href="{{ URL::asset('favicon.ico') }}" type='image/x-icon'/>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class='text-slate-900 bg-slate-900 p-2 sm:p-4 md:p-8' onload=IndicesPerRegion()>
        <x-selection/>
        <div class='grid md:grid-cols-2 xl:grid-cols-3 gap-2 sm:gap-4 md:gap-8'>
            <x-area title='Geographical'>
                <div id='map' class='w-full h-full'></div>
            </x-area>
            <x-area title='Trasactions'>
                <table id='transatable' class='w-full h-full max-w-[500px] text-slate-500'></table>
            </x-area>
            <x-area title='Composition'>
                <x-canvas id='compocanvas'/>
            </x-area>
            <x-area title='Statistics'>
                <x-canvas id='statscanvas'/>
            </x-area>
            <x-area title='Return' class='md:col-span-2'>
                <x-canvas id='intracanvas'/>
            </x-area>
        </div>
        <div class='text-center mt-8 text-slate-500'>
            &#169;2022 developed by <a class='text-slate-400' href='https://luvidal.edictus.com'>luvidal@edictus.com</a>
        </div>
    </body>
</html>
<script type='text/javascript'>

    const api = "{{ env('APP_URL') }}/api";

    ['intracanvas', 'statscanvas', 'compocanvas'].forEach(id => 
    {
        document.getElementById(id).style.width  = '100%';
        document.getElementById(id).style.height = '100%';
    });

</script>
