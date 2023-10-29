/* globals Chart:false */

(() => {
  'use strict'

  // Graphs
  const ctx = document.getElementById('myChart')
  // eslint-disable-next-line no-unused-vars
  const myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: "Temperature",
        lineTension: 0.3,
        backgroundColor: "rgba(78, 115, 223, 0.05)",
        borderColor: "rgba(78, 115, 223, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(78, 115, 223, 1)",
        pointBorderColor: "rgba(78, 115, 223, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: tempData,
      }, {
        label: "Wilgotność",
        lineTension: 0.3,
        backgroundColor: "rgba(223, 115, 78, 0.05)",
        borderColor: "rgba(223, 115, 78, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(223, 115, 78, 1)",
        pointBorderColor: "rgba(223, 115, 78, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(223, 115, 78, 1)",
        pointHoverBorderColor: "rgba(223, 115, 78, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: humidityData,
        yAxisID: 'humidity-axis',
        label: 'Wilgotność',
        callbacks: {
          label: function (tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            return datasetLabel + ": " + tooltipItem.yLabel + "%";
          }
        }
      }],
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      scales: {
        xAxes: [{
          time: {
            unit: 'date'
          },
          gridLines: {
            display: false,
            drawBorder: false
          },
          ticks: {
            maxTicksLimit: 7
          }
        }],
        yAxes: [{
          id: 'temperature-axis',
          ticks: {
            maxTicksLimit: 5,
            padding: 10,
            // Include a degree sign in the ticks
            callback: function (value, index, values) {
              return value + ' °C';
            }
          },
          gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
          }
        }, {
          id: 'humidity-axis',
          position: 'right',
          ticks: {
            maxTicksLimit: 5,
            padding: 10,
            // Include a percentage sign in the ticks
            callback: function (value, index, values) {
              return value + '%';
            }
          },
          gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
          }
        }],
      },
      legend: {
        display: false
      },
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: 'index',
        caretPadding: 10,
        callbacks: {
          label: function (tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            if (datasetLabel === 'Temperature') {
              return datasetLabel + ": " + tooltipItem.yLabel + " °C";
            } else if (datasetLabel === 'Wilgotność') {
              return datasetLabel + ": " + tooltipItem.yLabel + "%";
            } else {
              return datasetLabel + ": " + tooltipItem.yLabel;
            }
          }
        }
      }
    }
  });
})()
