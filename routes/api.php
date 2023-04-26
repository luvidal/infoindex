<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function() 
{
    return '{}';
});

Route::get('/intraini/{id}', function($id) 
{
    $gap = 15; // gap in minutes
    $timeline = [];
    $val = 100;
    $time = round(time()/($gap * 60)) * ($gap * 60);

    $ini = strtotime('-24 hours', $time);
    $fin = strtotime('now');

    for ($i=$ini; $i<=$fin; $i+=$gap*60) // every $gap mins
    {
        $iso = date('Y-m-d H:i', $i);
        $val += rand(-10, +10);
        $timeline[] = [ 'x' => $iso, 'y' => $val ];
    }

    return $timeline;
});

Route::get('/transactions/{id}', function() 
{
    function price()  { return number_format(rand(1000, 9999)); }
    function delta()  { return number_format(rand(10, 40)/10, 1); }
    function weight() { return rand(2, 12); }

    $stocks = [];
    $stocks[] = [ 'symbol' => 'MSFT', 'name' => 'Microsoft Corp', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'AAPL', 'name' => 'Apple Inc', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'AMZN', 'name' => 'Amazon', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'META', 'name' => 'Meta Platf', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'BRK.B','name' => 'Berkshire', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'TSLA', 'name' => 'Tesla Inc', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'AAL', 'name' => 'American Airl', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'ABNB', 'name' => 'Airbnb Inc', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'ABT', 'name' => 'Abbott Labs', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'ADBE', 'name' => 'Adobe Inc', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'BA', 'name' => 'Boeing Co', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'C', 'name' => 'Citigroup Inc', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'F', 'name' => 'Ford Motor Co', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'FDX', 'name' => 'Fedex Co', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'H', 'name' => 'Hyatt Hotels', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'KO', 'name' => 'Coca-Cola Co', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'NKE', 'name' => 'Nike Inc', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = [ 'symbol' => 'PFE', 'name' => 'Pfizer Inc', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];

    function cmp($a, $b) { return ($a['weight'] < $b['weight']);}
    usort($stocks, 'cmp');
    $stocks = array_slice($stocks, 0, 6);

    return $stocks;
});

Route::get('/compo/{id}', function() 
{
    $labels = ['Stocks', 'Corporates', 'Mortgages', 'Forex'];
    $total = 100; $percs = [];

    for($i=0; $i<count($labels)-1; $i++)
    {
        $aux = rand(1, $total);
        $percs[] = [ 'x' => $labels[$i], 'y' => $aux ];
        $total -= $aux;
    }

    $percs[] = [ 'x' => $labels[count($labels)-1], 'y' => $total ];
   
    return $percs;
});


Route::get('/stats/{id}', function() 
{
    $labels = ['MTD', 'QTD', 'YTD', 'YoY', 'VaR' , 'Volatilty'];

    $total = 100;
    $percs = [];

    for($i=0; $i<count($labels)-1; $i++)
    {
        $aux = rand(1, $total);
        $percs[] = [ 'x' => $labels[$i], 'y' => $aux ];
        $total -= $aux;
    }

    $percs[] = [ 'x' => $labels[count($labels)-1], 'y' => $total ];

    return $percs;
});


Route::get('/region/{region}', function($region) 
{
    $US = [ 'SP' => 'S&P 500', 'DJI' => 'Dow Jones', 'NSDQ' => 'Nasdaq', 'W5K' => 'Wilshire 5000' ];
    $EU = [ 'ENXT' => 'Euronext 100', 'FTSE' => 'FTSE 100 GB', 'CAC' => 'CAC 40 France', 'DAX' => 'DAX Germany' ];
    $LA = [ 'COLCAP' => 'COLCAP Colombia', 'MERVAL' => 'Merval Argentina', 'IPSA' => 'IPSA Chile' ];
    $EA = [ 'KOSPI' => 'KOSPI South Korea', 'NIKKEI' => 'NIKKEI Japan', 'HSENG' => 'Hang Seng China' ];

    return compact('US', 'EU', 'LA', 'EA')[$region];
});

Route::get('/maps/{region}', function($index) // https://jvectormap.com/maps
{
    switch($index)
    {
        case 'SP' : case 'DJI' : case 'NSDQ' : case 'W5K' : 
            $map = 'us';
            $regions = ['US-VA', 'US-PA', 'US-TN', 'US-WV', 'US-NV', 'US-TX', 'US-NH', 'US-NY', 'US-HI', 'US-VT', 'US-NM', 'US-NC', 'US-ND', 'US-NE', 'US-LA', 'US-SD', 'US-DC', 'US-DE', 'US-FL', 'US-CT', 'US-WA', 'US-KS', 'US-WI', 'US-OR', 'US-KY', 'US-ME', 'US-OH', 'US-OK', 'US-ID', 'US-WY', 'US-UT', 'US-IN', 'US-IL', 'US-AK', 'US-NJ', 'US-CO', 'US-MD', 'US-MA', 'US-AL', 'US-MO', 'US-MN', 'US-CA', 'US-IA', 'US-MI', 'US-GA', 'US-AZ', 'US-MT', 'US-MS', 'US-SC', 'US-RI', 'US-AR'];
            break;

        case 'ENXT' :
            $map = 'europe';
            $regions = ['IE', 'GB', 'IS', 'SI', 'HR', 'BA', 'DK', 'CZ', 'LU', 'BE', 'PT', 'FR', 'DE', 'NL', 'CH', 'SE', 'AT', 'ES', 'IT', 'NO'];
            break;

        case 'FTSE' : 
            $map = 'uk';
            $regions = ['NIR', 'SCT', 'WLS', 'ENG'];
            break;

        case 'CAC' : 
            $map = 'france';
            $regions = ['FR-GF', 'FR-H', 'FR-F', 'FR-E', 'FR-X1', 'FR-MQ', 'FR-YT', 'FR-X4', 'FR-X5', 'FR-X6', 'FR-X7', 'FR-X3', 'FR-R', 'FR-GP', 'FR-U', 'FR-J', 'FR-X2', 'FR-RE'];
            break;

        case 'DAX' :
            $map = 'germany';
            $regions = ['DE-BE', 'DE-ST', 'DE-RP', 'DE-BB', 'DE-NI', 'DE-MV', 'DE-TH', 'DE-BW', 'DE-HH', 'DE-SH', 'DE-NW', 'DE-SN', 'DE-HB', 'DE-SL', 'DE-BY', 'DE-HE'];
            break;

        case 'COLCAP' :
            $map = 'latam';
            $regions = ['CO'];
            break;

        case 'MERVAL' :
            $map = 'latam';
            $regions = ['AR'];
            break;

        case 'IPSA' :
            $map = 'latam';
            $regions = ['CL'];
            break;

        case 'KOSPI' :
            $map = 'skorea';
            $regions = ['KR-31','KR-49','KR-48','KR-45','KR-44','KR-47','KR-46','KR-41','KR-43','KR-42','KR-27','KR-11','KR-50','KR-29','KR-28','KR-30','KR-26'];
            break;

        case 'NIKKEI' :
            $map = 'asia';
            $regions = ['JP'];
            break;

        case 'HSENG' :
            $map = 'china';
            $regions = ['CN-32', 'CN-52', 'CN-53', 'CN-50', 'CN-51', 'CN-31', 'CN-54', 'CN-33', 'CN-15', 'CN-14', 'CN-', 'CN-12', 'CN-13', 'CN-11', 'CN-34', 'CN-36', 'CN-37', 'CN-41', 'CN-43', 'CN-42', 'CN-45', 'CN-44', 'CN-46', 'CN-65', 'CN-64', 'CN-63', 'CN-62', 'CN-61', 'CN-23', 'CN-22', 'CN-21'];
            break;
    }

    return [ 'map' => $map, 'regions' => $regions ];
});
