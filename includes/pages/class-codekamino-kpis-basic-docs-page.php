<?php

if ( ! class_exists( 'Codekamino_Kpis_Basic_Docs_Page' ) ) :
	class Codekamino_Kpis_Basic_Docs_Page {
		public static function render() {
			?>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<div class="wrap">
				<section class="text-gray-600 body-font bg-indigo-50">
					<div class="container px-5 py-24 mx-auto flex flex-wrap items-center">
						<div class="lg:w-3/5 md:w-1/2 md:pr-16 lg:pr-0 pr-0">
							<h1 class="title-font font-medium text-3xl text-gray-900"><?php _e( 'Wise KPIs', 'wise-kpis'); ?></h1>
							<h2 class="title-font font-medium text-xl text-gray-900"><?php _e( 'Introduction', 'wise-kpis'); ?></h2>
							<p class="leading-relaxed mt-4">
								<?php _e( 'Wise KPIs is a plugin for WordPress that allows you to track your website\'s key performance indicators (KPIs) in real-time. With Wise KPIs, you can monitor your website\'s traffic, sales, and other important metrics, and use this data to make informed decisions about your online business.', 'wise-kpis'); ?>
							</p>
						</div>
						<div class="bg-white rounded-lg shadow-md lg:w-2/6 md:w-1/2 md:ml-auto w-full mt-10 md:mt-0 p-8 flex flex-col">
							<h2 class="text-gray-900 font-medium text-lg title-font mb-5"><?php _e( 'Contact Us', 'wise-kpis'); ?></h2>
							<p class="text-gray-600 leading-relaxed mb-4">
								<?php printf( __( 'We welcome your feedback! Please feel free to reach out to us at <a href="mailto:%s" class="text-indigo-500 hover:text-indigo-600">%s</a>. We\'d love to hear your thoughts, feature requests, and bug reports.', 'wise-kpis'), 'codekamino@protonmail.com', 'codekamino@protonmail.com' ); ?>
							</p>
						</div>
					</div>
				</section>

				<section class="text-gray-600 body-font bg-indigo-50">
					<div class="container px-5 py-24 mx-auto">
						<div class="text-center mb-20">
							<h2 class="sm:text-3xl text-2xl font-medium text-center title-font text-gray-900 mb-4"><?php _e( 'Settings', 'wise-kpis'); ?></h2>
							<p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto text-gray-500s">
								<?php
								printf(
									__( 'You can access the Wise KPIs settings page by navigating to "Settings" in the WordPress dashboard and clicking on "Wise KPIs Settings".<br/>From here, you can choose the design for your KPI blocks.', 'wise-kpis')
								);
								?>
							</p>
						</div>
					</div>
				</section>

				<section class="text-gray-600 body-font bg-indigo-50">
					<div class="container px-5 py-24 mx-auto">
						<div class="text-center mb-20">
							<h2 class="sm:text-3xl text-2xl font-medium text-center title-font text-gray-900 mb-4"><?php _e( 'KPIs Blocks Design', 'wise-kpis'); ?></h2>
							<p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto text-gray-500s">
								<?php _e( 'This setting allows you to change the look and feel of the KPIs display. You can choose from the following design options:', 'wise-kpis'); ?>
							</p>
						</div>
						<div class="flex flex-wrap -m-4">
							<div class="xl:w-1/5 md:w-1/2 p-4">
								<div class="bg-gray-100 rounded-lg shadow-md p-6 kpi-block">
									<h2 class="text-xl font-bold mb-2"><?php _e( 'Simple', 'wise-kpis'); ?></h2>
								</div>
							</div>
							<div class="xl:w-1/5 md:w-1/2 p-4">
								<div class="bg-gray-900 rounded-lg shadow-md p-6 kpi-block">
									<h2 class="text-xl font-bold mb-2 text-white"><?php _e( 'Dark', 'wise-kpis'); ?></h2>
								</div>
							</div>
							<div class="xl:w-1/5 md:w-1/2 p-4">
								<div class="bg-gradient-to-br from-blue-900 to-purple-900 rounded-lg shadow-md p-6 kpi-block">
									<h2 class="text-xl font-bold mb-2 text-white"><?php _e( 'Gradient Background', 'wise-kpis'); ?></h2>
								</div>
							</div>
							<div class="xl:w-1/5 md:w-1/2 p-4">
								<div class="bg-gray-100 rounded-lg shadow-md p-6 kpi-block text-center">
									<h2 class="text-xl font-bold mb-2"><?php _e( 'Centered', 'wise-kpis'); ?></h2>
								</div>
							</div>
							<div class="xl:w-1/5 md:w-1/2 p-4">
								<div class="bg-white rounded-lg shadow-md p-6 kpi-block flex flex-col justify-center items-center">
									<h2 class="text-xl font-bold mb-2"><?php _e( 'Vertical <br/> Aligned', 'wise-kpis'); ?></h2>
								</div>
							</div>
						</div>
						<div class="md:flex-grow">
							<p class="mt-6 text-2xl">
								<?php _e( 'Every KPI page includes a date selection for generating the KPIs, the DEFAULT date range is for current day from start of the day to the current time', 'wise-kpis'); ?>
							</p>
						</div>
					</div>
				</section>
				<section class="text-gray-600 body-font bg-indigo-50">
					<div class="container px-5 py-24 mx-auto">
						<div class="-my-8 divide-y-2 divide-gray-100">
							<div class="py-8 flex flex-wrap md:flex-nowrap">
								<div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
									<span class="font-semibold title-font text-gray-700"><?php _e( 'Content', 'wise-kpis'); ?></span>
								</div>
								<div class="md:flex-grow">
									<p class="mb-6 text-xl">
										<?php _e( 'The KPI Blocks section displays KPIs (Key Performance Indicators) that provide valuable insights into your website\'s performance. The KPIs are grouped into three categories: WooCommerce, Content, and User.', 'wise-kpis'); ?>
									</p>
									<ul class="list-disc ml-6 mb-4">
										<li><?php _e( 'Average Comments Per Post', 'wise-kpis'); ?></li>
										<li><?php _e( 'Published Comments', 'wise-kpis'); ?></li>
										<li><?php _e( 'Published Posts', 'wise-kpis'); ?></li>
										<li><?php _e( 'Number Of Spam Comments', 'wise-kpis'); ?></li>
										<li><?php _e( 'Total Number of Published Comments', 'wise-kpis'); ?></li>
										<li><?php _e( 'Average Comments per User', 'wise-kpis'); ?></li>
										<li><?php _e( 'Average Post Length', 'wise-kpis'); ?></li>
									</ul>
								</div>
							</div>
							<div class="py-8 flex flex-wrap md:flex-nowrap">
								<div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
									<span class="font-semibold title-font text-gray-700"><?php _e( 'Woocommerce', 'wise-kpis'); ?></span>
								</div>
								<div class="md:flex-grow">
									<p class="mb-6 text-xl">
										<?php _e( 'The WooCommerce KPIs category displays KPIs related to your WooCommerce store. These KPIs include:', 'wise-kpis'); ?>
									</p>
									<ul class="list-disc ml-6 mb-4">
										<li><?php _e( 'Cost of Goods Sold', 'wise-kpis'); ?></li>
										<li><?php _e( 'Coupons Usage', 'wise-kpis'); ?></li>
										<li><?php _e( 'Total Completed Orders', 'wise-kpis'); ?></li>
										<li><?php _e( 'Total Number Of Orders', 'wise-kpis'); ?></li>
									</ul>
								</div>
							</div>
							<div class="py-8 flex flex-wrap md:flex-nowrap">
								<div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
									<span class="font-semibold title-font text-gray-700"><?php _e( 'Users', 'wise-kpis'); ?></span>
								</div>
								<div class="md:flex-grow">
									<p class="mb-6 text-xl">
										<?php _e( 'The User KPIs category displays KPIs related to your website\'s users. These KPIs include:', 'wise-kpis'); ?>
									</p>
									<ul class="list-disc ml-6 mb-4">
										<li><?php _e( 'Number of Users', 'wise-kpis'); ?></li>
										<li><?php _e( 'User Registration Growth Rate', 'wise-kpis'); ?></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<?php
		}
	}
endif;
