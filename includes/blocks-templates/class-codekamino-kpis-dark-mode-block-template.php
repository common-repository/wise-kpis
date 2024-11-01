<?php

if ( ! class_exists( 'Codekamino_Kpis_Dark_Mode_Block_Template' ) ) :
	class Codekamino_Kpis_Dark_Mode_Block_Template {
		public static function get_designed_block( string $kpi_name, string $description, float $current_value, float $previous_value, float $change_percentage, string $compare_unit ): string {
			$box = '<div class="bg-gray-900 rounded-lg shadow-md p-6 kpi-block">';
			$box .= '<h2 class="text-xl font-bold mb-2 text-white">' . $kpi_name . '</h2>';
			$box .= '<p class="text-gray-300 text-sm mb-2">' . $description . '</p>';
			$box .= '<div class="flex justify-between">';
			$box .= '<div class="kpi-value">';
			$box .= '<p class="text-3xl font-bold text-blue-600 mb-2 text-white">' . $current_value . '</p>';
			$box .= '<p class="text-gray-300 text-sm text-white">' . __( 'Current', 'wise-kpis') . '</p>';
			$box .= '<p class="text-3xl font-bold text-blue-600 mb-2 text-white">' . $previous_value . '</p>';
			$box .= '<p class="text-gray-300 text-sm text-white">' . ucwords( str_replace( "-", " ", $compare_unit ) ) . '</p>';
			$box .= '</div>';
			$box .= '<div class="kpi-change">';
			$box .= '<p class="text-3xl font-bold ' . ( $change_percentage >= 0 ? 'text-green-600' : 'text-red-600' ) . ' mb-2">' . $change_percentage . '%</p>';
			$box .= '<p class="text-gray-300 text-sm text-white">' . __( 'Change from', 'wise-kpis') . ' ' . str_replace( "-", " ", $compare_unit ) . '</p>';
			$box .= '</div>';
			$box .= '</div>';
			$box .= '</div>';

			return $box;
		}
	}
endif;
