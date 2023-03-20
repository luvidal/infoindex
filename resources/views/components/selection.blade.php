@php($class = 'bg-slate-800 border-8 border-slate-800 text-gray-300 rounded-lg block w-full max-w-[500px] mt-4')

<select id='region' class='{{ $class }}' onchange='IndicesPerRegion()'>
    <option value='US'>United States</option>
    <option value='EU'>Western Europe</option>
    <option value='LA'>Latin America</option>
    <option value='EA'>Eastern Asia</option>
</select>

<select id='index' class='{{ $class }}' onchange='GetIndexInfo()'>
</select>

<div class='opacity-50 mt-auto'>
    <i class='fa fa-warning mr-2'></i>This is a sample interface with random values.
</div>