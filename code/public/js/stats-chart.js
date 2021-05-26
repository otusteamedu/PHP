'use strict';

const chartLineElement = document.getElementById('chart-line');
const chartPieElement = document.getElementById('chart-pie');
const dateInputElement = document.getElementById('date-input');

let dateString;

init();

function init() {
  setDate()

  dateInputElement.addEventListener(`change`, handleDateChange);
  dateInputElement.value = dateString;

  google.charts.load('current', {'packages': ['corechart']});
  google.charts.setOnLoadCallback(draw);
}

function setDate(strDate = null) {
  const date = strDate ? new Date(strDate) : new Date();
  dateString = date.toISOString().slice(0, 10);
}

async function handleDateChange(evt) {
  setDate(evt.target.value);
  await draw();
}

async function draw() {
  const data = await loadData('GET', null, `date=${dateString}`);

  const {hours, cities} = data;

  const hits = hours.map((item) => [item.hour, item.count]);
  const citiesChunks = cities.map((item) => [item.city, item.count]);

  await drawLineChart(hits);
  await drawPieChart(citiesChunks);
}

async function drawLineChart(hits) {
  const data = new google.visualization.DataTable();
  data.addColumn('number', 'Hour');
  data.addColumn('number', 'Hits');
  data.addRows(hits);


  const options = {
    title: `Количество посещений` ,
    curveType: 'function',
    pointsVisible: true,
    pointShape: 'diamond',
    hAxis: {gridlines: { count: 0 }, format: `0` },
    vAxis: {format: `0`},
  };

  const chart = new google.visualization.LineChart(chartLineElement);
  chart.draw(data, options);
}

async function drawPieChart(chunks) {
  const data = new google.visualization.DataTable();
  data.addColumn('string', 'Cities');
  data.addColumn('number', 'count');
  data.addRows(chunks);

  const options = {
    'title':'Общий процент посещений по городам',
    'width':600,
    'height':400,
    is3D: true
  };

  const chart = new google.visualization.PieChart(chartPieElement);
  chart.draw(data, options);
}


