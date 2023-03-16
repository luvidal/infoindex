
import Chart from 'chart.js/auto'

const backgroundColor = ['salmon', 'turquoise', 'dodgerblue', 'sandybrown', 'mediumorchid', 'thistle'];
const server = 'localhost:8000';
const protocol = 'http';

export default function Indices()
{
    let region = document.getElementById('region').value;

    fetch(`${protocol}://${server}/api/region/${region}`)
    .then(resp => resp.json())
    .then(json => IndexDropDown(json))
}

function IndexDropDown(json)
{
    let indexes = document.getElementById('index');
    indexes.innerHTML = '';

    for (const key in json) 
    {
        let opt = document.createElement('option');
        opt.value = key;
        opt.innerHTML = json[key];
        indexes.append(opt);
    }

    GetIndexInfo()
}

function GetIndexInfo()
{
    for (var i=1; i<99999; i++) window.clearInterval(i);

    let index = document.getElementById('index').value;

    fetch(`${protocol}://${server}/api/stats/${index}`)
    .then(resp => resp.json())
    .then(json => Barchart(json))

    fetch(`${protocol}://${server}/api/compo/${index}`)
    .then(resp => resp.json())
    .then(json => Piechart(json))

    fetch(`${protocol}://${server}/api/transactions/${index}`)
    .then(resp => resp.json())
    .then(json => Transactions(json))

    fetch(`${protocol}://${server}/api/intraini/${index}`)
    .then(resp => resp.json())
    .then(json => IntraDay(index, json))
}

// ----------------------------------------------------------------------------------------


const barchart = new Chart (document.getElementById('statscanvas'),
{
    type:'bar',
    data:{ labels:[], datasets:[{ data:[], backgroundColor  }] },
    options:{ scales:{ y:{ beginAtZero:true, max:100 } }, plugins:{ legend:{ display:false }} },
})

function Barchart(json)
{
    let labels = [], data = []; json.map(row => // json to labels and data
    {
        labels.push(row.x)
        data.push(row.y)
    })

    barchart.data.labels = labels;
    barchart.update('none');

    setInterval( () => 
    {
       BarValues(data);
        barchart.data.datasets[0].data = data;
        barchart.update();

    }, 800);
}

function BarValues(data)
{
    let sign = -1, sensitivity = [9.0, 2.0, 1.0, 1.0, 0.5, 1.0]

    for (let i=0; i<data.length; i++)
    {
        sign = Math.round(Math.random()) * 2 - 1 // 1 or -1
        sign = data[i] >= 90 ? -1 : data[i] <= 10 ? 1 : sign;
        data[i] += sign * sensitivity[i];
    }
}

// ----------------------------------------------------------------------------------------

const piechart = new Chart (document.getElementById('compocanvas'),
{
    type:'doughnut',
    data:{ labels:[], datasets:[{ data:[], backgroundColor }] },
    options:{ borderWidth:0, plugins:{ legend:{ position:'right' }} }
})

function Piechart(json)
{
    let labels = [], data = []; json.map(row => // json to labels and data
    {
        labels.push(row.x)
        data.push(row.y)
    })

    piechart.data.labels = labels;
    piechart.update('none');

    setInterval( () => 
    {
        PieValues(data);
        piechart.data.datasets[0].data = data;
        piechart.update();

    }, 1200);
}

function PieValues(data)
{
    let sign = -1, sensitivity = [5.0, 4.0, 2.0, 1.0, 2.0, 1.0]

    for (let i=0; i<data.length; i++)
    {
        sign = Math.round(Math.random()) * 2 - 1 // 1 or -1
        sign = data[i] >= 70 ? -1 : data[i] <= 10 ? 1 : sign;
        data[i] += sign * sensitivity[i];
    }
}

// ----------------------------------------------------------------------------------------

function Transactions(data)
{
    const table = document.getElementById('transatable');
    table.innerHTML = '';
    data.map(row => AddTransaction(table, row))

    setInterval( () => 
    {
        if (!data.length) return;

        let unshuffled = []
        for(let i = 0; i < data.length; i++) unshuffled.push(i)

        let shuffled = unshuffled
            .map(v => ({ v, sort:Math.random() }))
            .sort((a, b) => a.sort - b.sort)
            .map(({ v }) => v)

        let n = Math.floor(Math.random() * data.length); // number of random transactions
        let transactions = shuffled.slice(0, n);

        for(let i=0; i<transactions.length; i++)
        {
            data[transactions[i]].sign  = Math.random() < 0.5 // true or false
            data[transactions[i]].price = Math.round(Math.floor(Math.random() * (9999 - 1000) + 1000), 1).toLocaleString('en-US')
            data[transactions[i]].delta = Math.round(10 + Math.random() * (4 - 1) + 1) / 10
        }

        table.innerHTML = '';
        data.map(row => AddTransaction(table, row))

    }, 800);
}

function AddTransaction(table, row) // row = { }
{
    const rotate = bool => bool ? 'rotate-[-90deg]' : 'rotate-[90deg]';
    const color  = bool => bool ? 'text-[salmon]' : 'text-[turquoise]';
    const sign   = bool => bool ? '-' : '+';

    let s = ``;
    s += `<tr>`;
    s += ` <td class='text-left'>${row.name}</td>`;
    s += ` <td class='text-left'>${row.symbol}</td>`;
    s += ` <td class='text-right'>${row.weight}%</td>`;
    s += ` <td class='text-right ${color(row.sign)}'>${sign(row.sign)}${row.price}</td>`;
    s += ` <td class='text-right'><i class='fa fa-play ${color(row.sign)} ${rotate(row.sign)}'></i></td>`;
    s += ` <td class='text-right ${color(row.sign)}'>${sign(row.sign)}${row.delta}%</td>`;
    s += `</tr>`;

    table.innerHTML += s;
}

// ----------------------------------------------------------------------------------------


const intrachart = new Chart (document.getElementById('intracanvas'),
{
    type:'line',
    options:{ plugins:{ legend:{ display:false }} },
    data:{ labels:[], datasets:[{ data:[] }] }
})

function IntraDay(index, json)
{
    let labels = [], data = []; json.map(row => // json to labels and data
    {
        labels.push(row.x.split(' ')[1])
        data.push(row.y)
    })

    intrachart.data.labels = labels;
    intrachart.data.datasets[0].data = data;
    intrachart.update('none');
    
    setInterval( () => 
    {
        IntraValues(labels, data);
        intrachart.data.labels = labels;
        intrachart.data.datasets[0].data = data;
        intrachart.update('none');

    }, 900);
}

function IntraValues(labels, data)
{
    let sign = Math.round(Math.random()) * 2 - 1 // 1 or -1
    let rand = Math.floor(Math.random() * (10 - 5 + 1) + 5) // 5 ... 10
    data.push(data[data.length-1] + sign * rand);
    data.shift();
    
    let time = labels[labels.length-1]
    let mins = 15;
    let newT = new Date(new Date('1970/01/01 ' + time).getTime() + mins * 60000).toLocaleTimeString('en-UK', { hour:'2-digit', minute:'2-digit', hour12:false });
    labels.push(newT);
    labels.shift();
}
