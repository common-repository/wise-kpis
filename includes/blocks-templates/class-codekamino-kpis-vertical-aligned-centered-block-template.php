<?php

if (!class_exists('Codekamino_Kpis_Vertical_Aligned_Centered_Block_Template')) :
	class Codekamino_Kpis_Vertical_Aligned_Centered_Block_Template
	{
		public static function get_designed_block(string $kpi_name, string $description, float $current_value, float $previous_value, float $change_percentage, string $compare_unit): string
		{
			$box = '<div class="bg-white rounded-lg shadow-md p-6 kpi-block flex flex-col justify-center items-center">';
			$box .= '<h2 class="text-xl font-bold mb-2">' . $kpi_name . '</h2>';
			$box .= '<p class="text-gray-500 text-sm mb-2">' . $description . '</p>';
			$box .= '<div class="flex justify-between">';
			$box .= '<div class="kpi-value text-center">';
			$box .= '<p class="text-3xl font-bold text-blue-600 mb-2">' . $current_value . '</p>';
			$box .= '<p class="text-gray-500 text-sm">' . __('Selected', 'your-plugin-domain') . '</p>';
			$box .= '<p class="text-3xl font-bold text-blue-600 mb-2">' . $previous_value . '</p>';
			$box .= '<p class="text-gray-500 text-sm">' . ucwords(str_replace("-", " ", $compare_unit)) . '</p>';
			$box .= '</div>';
			$box .= '<div class="kpi-change text-center">';
			$box .= '<p class="text-3xl font-bold ' . ($change_percentage >= 0 ? 'text-green-600' : 'text-red-600') . ' mb-2">' . $change_percentage . '%</p>';
			$box .= '<p class="text-gray-500 text-sm">' . __('Change from', 'your-plugin-domain') . ' ' . str_replace("-", " ", $compare_unit) . '</p>';
			$box .= '</div>';
			$box .= '</div>';
			$box .= '</div>';

			return $box;
		}
	}
endif;
