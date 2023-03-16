<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function() 
{
    return '{}';
});

Route::get('/region/{region}', function($region) 
{
    $US = [ 'SP' => 'S&P 500', 'DJI' => 'Dow Jones', 'NSDQ' => 'Nasdaq', 'W5K' => 'Wilshire 5000' ];
    $EU = [ 'FTSE' => 'FTSE 100 GB', 'ENXT' => 'Euronext 100', 'CAC' => 'CAC 40 France', 'DAX' => 'DAX Germany' ];
    $LA = [ 'COLCAP' => 'COLCAP Colombia', 'MERVAL' => 'Merval Argentina', 'IPSA' => 'IPSA Chile' ];
    $EA = [ 'KOSPI' => 'KOSPI South Korea', 'NIKKEI' => 'NIKKEI Japan', 'HSENG' => 'Hang Seng China' ];

    return compact('US', 'EU', 'LA', 'EA')[$region];
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
    $stocks[] = (object)[ 'symbol' => 'MSFT', 'name' => 'Microsoft Corp', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'AAPL', 'name' => 'Apple Inc',     'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'AMZN', 'name' => 'Amazon',    'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'META', 'name' => 'Meta Platf',      'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'BRK.B','name' => 'Berkshire', 'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'TSLA', 'name' => 'Tesla Inc',     'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'AAL', 'name' => 'American Airl',  'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'ABNB', 'name' => 'Airbnb Inc',  'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'ABT', 'name' => 'Abbott Labs',  'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'ADBE', 'name' => 'Adobe Inc',  'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'BA', 'name' => 'Boeing Co',  'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'C', 'name' => 'Citigroup Inc',  'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'F', 'name' => 'Ford Motor Co',  'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'FDX', 'name' => 'Fedex Co',  'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'H', 'name' => 'Hyatt Hotels',  'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'KO', 'name' => 'Coca-Cola Co',  'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'NKE', 'name' => 'Nike Inc',  'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];
    $stocks[] = (object)[ 'symbol' => 'PFE', 'name' => 'Pfizer Inc',  'weight' => weight(), 'price' => price(), 'delta' => delta(), 'sign' => rand(0,1) ];

    function cmp($a, $b) { return ($a->weight < $b->weight);}
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