<?php

if (!class_exists('Codekamino_Sales_Chart_Calculator')) :

    class Codekamino_Sales_Chart_Calculator implements Codekamino_Kpis_Chart_Calculator_Interface
    {
        private $wpdb;

        public function __construct(wpdb $wpdb)
        {
            $this->wpdb = $wpdb;
        }

        public function calculate(string $start_date, string $end_date)
        {
            $start_date = sanitize_text_field($start_date);
            $end_date = sanitize_text_field($end_date);

            $table_name = $this->wpdb->prefix . 'wc_order_stats';

            $query = $this->wpdb->prepare(
                "
                        SELECT DATE(date_created) as day, COUNT(order_id) as sales
                        FROM {$table_name}
                        WHERE date_created >= %s AND date_created <= %s
                        GROUP BY DATE(date_created)
                        ORDER BY DATE(date_created) ASC
                        ",
                $start_date,
                $end_date
            );

            return $this->wpdb->get_results($query);
        }
    }
endif;
