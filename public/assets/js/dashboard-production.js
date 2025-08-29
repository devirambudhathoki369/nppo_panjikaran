// calling ajax to get the data for plotting into chart
$(document).ready(function () {
  $.ajax({
    method: "POST",
    url: ajaxURLChart + "get-data-for-production-dashboard-chart",
    data: {
      _token: csrf
    }
  })

    .done(function (resp) {

      respData = (resp)

      var options,
        chart,
        areachartSalesColors = respData.bgColor,
        dealTypeChartsColors =
          (areachartSalesColors &&
            ((options = {
              series: respData.coreData,
              chart: { type: "bar", height: 300, toolbar: { show: !1 } },
              plotOptions: { bar: { horizontal: !1, columnWidth: "80%" } },
              stroke: { show: !0, width: 5, colors: ["transparent"] },
              xaxis: {
                categories: [""],
                axisTicks: { show: !1, borderType: "solid", color: "#78909C", height: 6, offsetX: 0, offsetY: 0 },
                title: { text: "Production Data", offsetX: 0, offsetY: -30, style: { color: "#78909C", fontSize: "12px", fontWeight: 400 } },
              },
              yaxis: {
                labels: {
                  formatter: function (e) {
                    return + e;
                  },
                },
                tickAmount: 4,
                min: 0,
              },
              fill: { opacity: 1 },
              legend: { show: !0, position: "bottom", horizontalAlign: "center", fontWeight: 500, offsetX: 0, offsetY: -14, itemMargin: { horizontal: 8, vertical: 0 }, markers: { width: 10, height: 10 } },
              colors: areachartSalesColors,
            }),

              (chart = new ApexCharts(document.querySelector("#voucher-transaction-chart"), options)).render()));
    })
    .fail(function (resp) {

    })
});