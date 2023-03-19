<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset='utf-8'/>
        <meta name='viewport' content='width=device-width, initial-scale=1'/>
        <title>InfoIndex</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script> const api = "{{ env('APP_URL') }}/api"; </script>
    </head>
    <body class='text-slate-200 bg-slate-900 p-2 sm:p-4 md:p-8' onload='IndicesPerRegion()'>
        <div class='grid md:grid-cols-2 xl:grid-cols-3  gap-2 sm:gap-4 md:gap-8'>
            {!! section(selection()) !!}
            {!! section(transactions()) !!}
            {!! section(compochart()) !!}
            {!! section(statschart()) !!}
            {!! section(intrachart(), 'md:col-span-2') !!}
        </div>
        <div class='text-center mt-8 text-slate-500'>
            &#169;2022 developed by <a class='text-slate-400' href='https://luvidal.edictus.com'>luvidal@edictus.com</a>
        </div>
    </body>
</html>

<?php

    function section($inner = '', $class = '')
    {
        return "<div class='flex flex-col items-center h-96 border-2 border-slate-800 rounded-lg p-2 sm:p-4 md:p-8 min-w-[350px] $class'>$inner</div>";
    }

    function selection()
    {
        $class = "bg-slate-800 border-8 border-slate-800 text-gray-300 rounded-lg block w-full max-w-[500px]"; 

        $s  = "<select id='region' class='$class mt-4' onchange='IndicesPerRegion()'>";
        $s .= ' <option value="US">United States</option>';
        $s .= ' <option value="EU">Western Europe</option>';
        $s .= ' <option value="LA">Latin America</option>';
        $s .= ' <option value="EA">Eastern Asia</option>';
        $s .= '</select>';

        $s .= "<select id='index' class='$class mt-8' onchange='GetIndexInfo()'>";
        $s .= '</select>';

        $s .= '<div class="opacity-50 mt-auto">';
        $s .= " <i class='fa fa-warning mr-2'></i>This is a sample interface with random values.";
        $s .= '</div>';

        return $s;
    }

    function transactions()
    {
        return '<table id="transatable" class="w-full h-full max-w-[500px]"></table>';
    }

    function compochart()
    {
        return "<canvas id='compocanvas'></canvas>";
    }

    function intrachart()
    {  
        $s  = "<canvas id='intracanvas'></canvas>";
        $s .= "<script>";
        $s .= "let intracanvas = document.getElementById('intracanvas');";
        $s .= "intracanvas.style.width  = '100%';";
        $s .= "intracanvas.style.height = '100%';";
        $s .= "</script>";
        return $s;
    }

    function statschart()
    {
        $s  = "<canvas id='statscanvas'></canvas>";
        $s .= "<script>";
        $s .= "let statscanvas = document.getElementById('statscanvas');";
        $s .= "statscanvas.style.width  = '100%';";
        $s .= "statscanvas.style.height = '100%';";
        $s .= "</script>";
        return $s;
    }
?>