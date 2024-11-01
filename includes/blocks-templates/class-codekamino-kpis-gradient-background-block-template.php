<?php

if ( ! class_exists( 'Codekamino_Kpis_Gradient_Background_Block_Template' ) ) :
	class Codekamino_Kpis_Gradient_Background_Block_Template {
		public static function get_designed_block( string $kpi_name, string $description, float $current_value, float $previous_value, float $change_percentage, string $compare_unit ): string {
			$box = '<div class="bg-gradient-to-br from-blue-900 to-purple-900 rounded-lg shadow-md p-6 kpi-block">';
			$box .= '<h2 class="text-xl font-bold mb-2 text-white">' . $kpi_name . '</h2>';
			$box .= '<p class="text-gray-300 text-sm mb-2">' . $description . '</p>';
			$box .= '<div class="flex justify-between">';
			$box .= '<div class="kpi-value text-white">';
			$box .= '<p class="text-3xl font-bold text-blue-200 mb-2">' . $current_value . '</p>';
			$box .= '<p class="text-gray-300 text-sm">' . __( 'Current', 'wise-kpis') . '</p>';
			$box .= '<p class="text-3xl font-bold text-blue-200 mb-2">' . $previous_value . '</p>';
			$box .= '<p class="text-gray-300 text-sm">' . ucwords( str_replace( "-", " ", $compare_unit ) ) . '</p>';
			$box .= '</div>';
			$box .= '<div class="kpi-change text-white">';
			$box .= '<p class="text-3xl font-bold ' . ( $change_percentage >= 0 ? 'text-green-300' : 'text-red-300' ) . ' mb-2">' . $change_percentage . '%</p>';
			$box .= '<p class="text-gray-300 text-sm">' . __( 'Change from', 'wise-kpis') . ' ' . str_replace( "-", " ", $compare_unit ) . '</p>';
			$box .= '</div>';
			$box .= '</div>';
			$box .= '</div>';

			return $box;
		}
	}
endif;
