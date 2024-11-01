<?php

if (!class_exists('Codekamino_Kpis_Woocommerce_Kpis_Page')) :
    class Codekamino_Kpis_Woocommerce_Kpis_Page
    {
        public static function render()
        {
            global $wpdb;
            $start_date = isset($_POST['start-date']) ? sanitize_text_field($_POST['start-date']) . ' 00:00:00' : '';
            $end_date = isset($_POST['end-date']) ? sanitize_text_field($_POST['end-date']) . ' ' . date('H:i:s') : '';
            $unit_type = isset($_POST['unit-type']) ? sanitize_text_field($_POST['unit-type']) : 'yesterday'; // Default unit type

            $frameObject = (object)[
                'start_date' => $start_date,
                'end_date' => $end_date,
                'unit_type' => $unit_type
            ];

            $query_timeframe = new Codekamino_Kpis_Timeframe_Model($frameObject);
            $timeframe_processor = new Codekamino_Kpis_Date_Calculator_Processor($query_timeframe);
            $query_timeframe = $timeframe_processor->process();
            $kpi_blocks_iterator = new Codekamino_Kpis_Blocks_Iterator($wpdb, 'kpis/woocommerce/blocks', $query_timeframe);
            $kpi_blocks = new Codekamino_Kpis_Kpi_Blocks($kpi_blocks_iterator);

            // Retrieve chart data using chart calculators
            $salesCalculator = new Codekamino_Sales_Chart_Calculator($wpdb);

            $start_date = $query_timeframe->start_date ?? date('Y-m-d', strtotime('-15 days')) . ' 00:00:00';
            $end_date = $query_timeframe->end_date ?? date('Y-m-d') . ' ' . date('H:i:s');

            $salesData = ($start_date && $end_date) ? $salesCalculator->calculate($start_date, $end_date) : [];


            $netSalesCalculator = new Codekamino_Net_Sales_Chart_Calculator($wpdb);
            $netSalesData = ($start_date && $end_date) ? $netSalesCalculator->calculate($start_date, $end_date) : [];
            ?>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <div class="wrap">
                <?php if (!isset($_GET['auto_refresh'])) : ?>
                    <button onclick="activateAutoRefresh()"
                            class="mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <?php _e('Activate Auto Refresh', 'wise-kpis'); ?>
                    </button>
                <?php endif; ?>
                <h1 class="text-3xl font-bold mb-8"><?php _e('Woocommerce KPIs', 'wise-kpis'); ?></h1>
                <?php if (!isset($_GET['auto_refresh'])) : ?>
                    <form method="POST">
                        <form method="POST">
                            <div class="mb-4 flex flex-col sm:flex-row sm:items-center">
                                <label for="start-date" class="mr-2"><?php _e('Start Date:', 'wise-kpis'); ?></label>
                                <input type="date" id="start-date" name="start-date"
                                       value="<?= $start_date ? esc_attr(date('Y-m-d', strtotime($start_date))) : date('Y-m-d'); ?>"
                                       class="p-2 rounded-md mb-2 sm:mb-0 sm:mr-4">

                                <label for="end-date" class="mr-2"><?php _e('End Date:', 'wise-kpis'); ?></label>
                                <input type="date" id="end-date" name="end-date"
                                       value="<?= $end_date ? esc_attr(date('Y-m-d', strtotime($end_date))) : date('Y-m-d'); ?>"
                                       class="p-2 rounded-md mb-2 sm:mb-0 sm:mr-4">

                                <label for="unit-type"
                                       class="mr-2"><?php _e('Compared Unit:', 'wise-kpis'); ?></label>
                                <select id="unit-type" name="unit-type" class="p-2 rounded-md">
                                    <option value="yesterday"><?php _e('Yesterday', 'wise-kpis'); ?></option>
                                    <option value="last-week"><?php _e('Last Week', 'wise-kpis'); ?></option>
                                    <option value="last-month"><?php _e('Last Month', 'wise-kpis'); ?></option>
                                    <option value="last-year"><?php _e('Last Year', 'wise-kpis'); ?></option>
                                </select>

                                <button type="submit" name="submit"
                                        class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    <?php _e('Submit', 'wise-kpis'); ?>
                                </button>
                            </div>
                            <div class="mb-4 text-xl">
                                <?php
                                if (empty($frameObject->start_date)) {
                                    ?>
                                    <span class="text-gray-600"><?php _e('Selected Date', 'wise-kpis'); ?>
                                <b><?php _e('Today', 'wise-kpis'); ?></b></span>
                                    <span class="text-gray-600"><?php _e('Compared Unit:', 'wise-kpis'); ?></span>
                                    <span class="font-bold"><?= esc_html(ucfirst(str_replace('-', ' ', $frameObject->unit_type))); ?></span>
                                    <?php
                                } else {
                                    ?>
                                    <span class="text-gray-600"><?php _e('Selected Date Range:', 'wise-kpis'); ?></span>
                                    <span class="font-bold"><b><?= esc_html(date_i18n(get_option('date_format'), strtotime($frameObject->start_date))); ?></b></span>
                                    <span class="text-gray-600"><?php _e('to', 'wise-kpis'); ?></span>
                                    <span class="font-bold"><b><?= esc_html(date_i18n(get_option('date_format'), strtotime($frameObject->end_date))); ?></b></span>
                                    <span class="text-gray-600"><?php _e('Compared Unit:', 'wise-kpis'); ?></span>
                                    <span class="font-bold"><b><?= esc_html(ucfirst(str_replace('-', ' ', $frameObject->unit_type))); ?></b></span>
                                    <?php
                                }
                                ?>
                            </div>
                        </form>
                    </form>
                <?php endif; ?>
                <div class="grid grid-cols-1 gap-6">
                    <!-- Sales Chart -->
                    <div class="w-full chart-container">
                        <p class="text-md font-bold">Last 15 days</p>
                        <div id="combined-chart"></div>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <?php $kpi_blocks->render($query_timeframe); ?>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                        // Sales Chart Data
                        const salesData = <?= json_encode($salesData); ?>;

                        // Net Sales Chart Data
                        const netSalesData = <?= json_encode($netSalesData); ?>;

                        const currencySymbol = '<?= html_entity_decode(get_woocommerce_currency_symbol()); ?>';

                        const chartOptions = {
                            chart: {
                                type: 'bar',
                                height: 350,
                            },
                            series: [
                                {
                                    name: 'Sales',
                                    data: salesData.map((item) => item.sales),
                                },
                                {
                                    name: 'Net Sales',
                                    data: netSalesData.map((item) => {
                                        const floatAmount = parseFloat(item.net_sales);

                                        return floatAmount.toFixed(2);
                                    }),
                                },
                            ],
                            plotOptions: {
                                bar: {
                                    dataLabels: {
                                        position: 'top', // top, center, bottom
                                    },
                                }
                            },
                            yaxis: {
                                labels: {
                                    formatter: function (value) {
                                        return currencySymbol + ' ' + value.toLocaleString(undefined, {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        });
                                    },
                                }
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            xaxis: {
                                categories: salesData.map((item) => item.day),
                            },
                            colors: ['#079768', '#530679'],
                        };

                        const chart = new ApexCharts(document.querySelector("#combined-chart"), chartOptions);
                        chart.render();
                    }
                )
                ;

                // Auto Refresh
                function activateAutoRefresh() {
                    window.location.href = '<?php echo add_query_arg('auto_refresh', 'true'); ?>';
                }



                <?php if (isset($_GET['auto_refresh'])) : ?>
                setInterval(function () {
                    location.reload();
                }, 300000); // 5 minutes in milliseconds
                <?php endif; ?>
            </script>

            <?php
        }
    }
endif;
