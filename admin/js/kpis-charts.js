document.addEventListener('DOMContentLoaded', function() {
    fetch(kpis_charts_obj.ajax_url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded;',
        },
        body: 'action=get_kpis_chart_data&start_date=' + encodeURIComponent('your_start_date') + '&end_date=' + encodeURIComponent('your_end_date') + '&nonce=' + encodeURIComponent(kpis_charts_obj.nonce),
    })
        .then(response => response.json())
        .then(data => {
            // Here you can update your chart with data.sales_data, data.net_sales_data, data.discounts_data
        })
        .catch((error) => {
            console.error('Error:', error);
        });
});
