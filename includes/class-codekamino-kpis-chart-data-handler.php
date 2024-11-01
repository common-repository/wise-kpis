<?php

if (!class_exists('Codekamino_Kpis_Chart_Data_Handler')):
    class Codekamino_Kpis_Chart_Data_Handler
    {
        private $wpdb;

        public function __construct(wpdb $wpdb)
        {
            $this->wpdb = $wpdb;
            add_action('wp_ajax_get_kpis_chart_data', [$this, 'get_chart_data']);
        }

        public function get_chart_data()
        {
            check_ajax_referer('kpis_charts_nonce', 'nonce');

            $start_date = sanitize_text_field($_POST['start_date']);
            $end_date = sanitize_text_field($_POST['end_date']);

            // Validate the dates
            if (!$this->is_valid_date($start_date) || !$this->is_valid_date($end_date)) {
                wp_send_json_error('Invalid date format.');
                return;
            }

            try {
                // Create the chart calculators
                $sales_calculator = new Codekamino_Sales_Chart_Calculator($this->wpdb);
                $net_sales_calculator = new Codekamino_Net_Sales_Chart_Calculator($this->wpdb);
                $discounts_calculator = new Codekamino_Discounts_Chart_Calculator($this->wpdb);

                // Get the data
                $sales_data = $sales_calculator->calculate($start_date, $end_date);
                $net_sales_data = $net_sales_calculator->calculate($start_date, $end_date);
                $discounts_data = $discounts_calculator->calculate($start_date, $end_date);
            } catch (Exception $e) {
                // Handle the error
                wp_send_json_error($e->getMessage());
                return;
            }

            // Return the data
            wp_send_json([
                'sales_data' => $sales_data,
                'net_sales_data' => $net_sales_data,
                'discounts_data' => $discounts_data,
            ]);
        }

        private function is_valid_date($date)
        {
            $d = DateTime::createFromFormat('Y-m-d', $date);
            return $d && $d->format('Y-m-d') === $date;
        }
    }
endif;
