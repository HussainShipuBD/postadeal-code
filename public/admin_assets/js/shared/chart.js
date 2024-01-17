$(function () {
  /* ChartJS */
  'use strict';
  
  if ($("#barChart").length) {
    var monthValue = document.getElementById('monthValue').value;
    var months  = JSON.parse(monthValue);
       
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: 'Users',
          data: months,
          backgroundColor: ChartColor[0],
          borderColor: ChartColor[0],
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        layout: {
          padding: {
            left: 0,
            right: 0,
            top: 0,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Users by year',
              fontSize: 12,
              lineHeight: 2
            },
            ticks: {
              fontColor: '#bfccda',
              stepSize: 50,
              min: 0,
              max: 150,
              autoSkip: true,
              autoSkipPadding: 15,
              maxRotation: 0,
              maxTicksLimit: 10
            },
            gridLines: {
              display: false,
              drawBorder: false,
              color: 'transparent',
              zeroLineColor: '#eeeeee'
            }
          }],
          yAxes: [{
            display: true,
            scaleLabel: {
              display: true,
              labelString: 'Count by users',
              fontSize: 12,
              lineHeight: 2
            },
            ticks: {
              display: true,
              autoSkip: false,
              maxRotation: 0,
              fontColor: '#bfccda',
              stepSize: 10,
              min: 0,
              max: 50
            },
            gridLines: {
              drawBorder: false
            }
          }]
        },
        legend: {
          display: false
        },
        legendCallback: function (chart) {
          var text = [];
          text.push('<div class="chartjs-legend"><ul>');
          for (var i = 0; i < chart.data.datasets.length; i++) {
            console.log(chart.data.datasets[i]); // see what's inside the obj.
            text.push('<li>');
            text.push('<span style="background-color:' + chart.data.datasets[i].backgroundColor + '">' + '</span>');
            text.push(chart.data.datasets[i].label);
            text.push('</li>');
          }
          text.push('</ul></div>');
          return text.join("");
        },
        elements: {
          point: {
            radius: 0
          }
        }
      }
    });
    document.getElementById('bar-traffic-legend').innerHTML = barChart.generateLegend();
  }
  
  if ($('#scatterChart').length) {
    var options = {
      type: 'bubble',
      data: {
        datasets: [{
            label: 'John',
            data: [{
              x: 3,
              y: 10,
              r: 5
            }],
            backgroundColor: ChartColor[0],
            borderColor: ChartColor[0],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[0]
          },
          {
            label: 'Paul',
            data: [{
              x: 2,
              y: 2,
              r: 10
            }],
            backgroundColor: ChartColor[1],
            borderColor: ChartColor[1],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[1]
          }, {
            label: 'Paul',
            data: [{
              x: 12,
              y: 32,
              r: 13
            }],
            backgroundColor: ChartColor[2],
            borderColor: ChartColor[2],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[2]
          },
          {
            label: 'Paul',
            data: [{
              x: 29,
              y: 52,
              r: 5
            }],
            backgroundColor: ChartColor[0],
            borderColor: ChartColor[0],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[0]
          },
          {
            label: 'Paul',
            data: [{
              x: 49,
              y: 62,
              r: 5
            }],
            backgroundColor: ChartColor[1],
            borderColor: ChartColor[1],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[1]
          },
          {
            label: 'Paul',
            data: [{
              x: 22,
              y: 22,
              r: 5
            }],
            backgroundColor: ChartColor[2],
            borderColor: ChartColor[2],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[2]
          },
          {
            label: 'Paul',
            data: [{
              x: 23,
              y: 25,
              r: 5
            }],
            backgroundColor: ChartColor[1],
            borderColor: ChartColor[1],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[1]
          },
          {
            label: 'Paul',
            data: [{
              x: 12,
              y: 10,
              r: 5
            }],
            backgroundColor: ChartColor[1],
            borderColor: ChartColor[1],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[1]
          },
          {
            label: 'Paul',
            data: [{
              x: 34,
              y: 23,
              r: 5
            }],
            backgroundColor: ChartColor[1],
            borderColor: ChartColor[1],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[1]
          },
          {
            label: 'Paul',
            data: [{
              x: 30,
              y: 20,
              r: 10
            }],
            backgroundColor: ChartColor[1],
            borderColor: ChartColor[1],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[1]
          },
          {
            label: 'Paul',
            data: [{
              x: 12,
              y: 17,
              r: 5
            }],
            backgroundColor: ChartColor[1],
            borderColor: ChartColor[1],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[1]
          },
          {
            label: 'Paul',
            data: [{
              x: 32,
              y: 37,
              r: 5
            }],
            backgroundColor: ChartColor[0],
            borderColor: ChartColor[0],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[0]
          },
          {
            label: 'Paul',
            data: [{
              x: 52,
              y: 57,
              r: 5
            }],
            backgroundColor: ChartColor[0],
            borderColor: ChartColor[0],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[0]
          },
          {
            label: 'Paul',
            data: [{
              x: 77,
              y: 40,
              r: 5
            }],
            backgroundColor: ChartColor[0],
            borderColor: ChartColor[0],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[0]
          }, {
            label: 'Paul',
            data: [{
              x: 67,
              y: 40,
              r: 5
            }],
            backgroundColor: ChartColor[0],
            borderColor: ChartColor[0],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[0]
          }, {
            label: 'Paul',
            data: [{
              x: 47,
              y: 20,
              r: 10
            }],
            backgroundColor: ChartColor[0],
            borderColor: ChartColor[0],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[0]
          }, {
            label: 'Paul',
            data: [{
              x: 77,
              y: 10,
              r: 5
            }],
            backgroundColor: ChartColor[0],
            borderColor: ChartColor[0],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[0]
          }, {
            label: 'Paul',
            data: [{
              x: 57,
              y: 10,
              r: 10
            }],
            backgroundColor: ChartColor[0],
            borderColor: ChartColor[0],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[0]
          }, {
            label: 'Paul',
            data: [{
              x: 57,
              y: 40,
              r: 5
            }],
            backgroundColor: ChartColor[3],
            borderColor: ChartColor[3],
            borderWidth: 0,
            hoverBackgroundColor: ChartColor[3]
          }
        ]
      },
      options: {
        legend: false,
        scales: {
          xAxes: [{
            gridLines: {
              display: false,
              color: '#fff',
            },
            ticks: {
              autoSkip: true,
              autoSkipPadding: 45,
              maxRotation: 0,
              maxTicksLimit: 10,
              fontColor: '#212229'
            }
          }],
          yAxes: [{
            gridLines: {
              color: '#eff2ff',
              display: true
            },
            ticks: {
              beginAtZero: true,
              stepSize: 25,
              max: 100,
              fontColor: '#212229'
            }
          }]
        },
        legend: {
          display: false
        },
        legendCallback: function (chart) {
          var text = [];
          text.push('<div class="chartjs-legend"><ul>');
          for (var i = 0; i < chart.data.datasets.length; i++) {
            console.log(chart.data.datasets[i]); // see what's inside the obj.
            text.push('<li>');
            text.push('<span style="background-color:' + chart.data.datasets[i].backgroundColor + '">' + '</span>');
            text.push(chart.data.datasets[i].label);
            text.push('</li>');
          }
          text.push('</ul></div>');
          return text.join("");
        },
      }
    }

    var ctx = document.getElementById('scatterChart').getContext('2d');
    new Chart(ctx, options);
    document.getElementById('scatter-chart-legend').innerHTML = barChart.generateLegend();
  }
});