@php($container = 'border-2 border-slate-700 bg-slate-600/25 rounded-lg p-2 mb-7')
@php($select    = 'bg-slate-900 text-slate-100 border-slate-900 border-8 rounded-lg m-1 w-full max-w-[300px]')
@php($text      = 'whitespace-nowrap uppercase text-slate-400/75 mr-8')

<div class='{{ $container }}'>

    <span class='{{ $text }}'>
        <div class='inline-block w-16' styleXXX='width:100px; border:1px solid magenta;'>Region</div>
        <select id='region' class='{{ $select }}' onchange='IndicesPerRegion()'>
            <option value='US'>United States</option>
            <option value='EU'>Western Europe</option>
            <option value='LA'>Latin America</option>
            <option value='EA'>Eastern Asia</option>
        </select>
    </span>

    <span class='{{ $text }}'>
        <div class='inline-block w-16' styleXXX='width:100px; border:1px solid magenta;'>Index</div>
        <select id='index' class='{{ $select }}' onchange='GetIndexInfo()'>
        </select>
    </span>

</div>