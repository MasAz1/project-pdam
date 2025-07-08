@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
	<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
		<!-- Device Summary Card -->
		<div class="bg-white rounded-lg shadow p-6">
			<h3 class="text-lg font-semibold text-green-600 mb-4">Device Summary</h3>
			<div class="flex justify-between">
				<div class="text-center">
					<div class="text-2xl font-bold">142</div>
					<div class="text-gray-500 text-sm">Total Devices</div>
				</div>
				<div class="text-center">
					<div class="text-2xl font-bold">128</div>
					<div class="text-gray-500 text-sm">Online</div>
				</div>
				<div class="text-center">
					<div class="text-2xl font-bold">14</div>
					<div class="text-gray-500 text-sm">Offline</div>
				</div>
			</div>
		</div>

		<!-- Firmware Summary Card -->
		<div class="bg-white rounded-lg shadow p-6">
			<h3 class="text-lg font-semibold text-green-600 mb-4">Firmware Summary</h3>
			<div class="flex justify-between">
				<div class="text-center">
					<div class="text-2xl font-bold">8</div>
					<div class="text-gray-500 text-sm">Firmware Versions</div>
				</div>
				<div class="text-center">
					<div class="text-2xl font-bold">v2.4.1</div>
					<div class="text-gray-500 text-sm">Latest Version</div>
				</div>
				<div class="text-center">
					<div class="text-2xl font-bold">42</div>
					<div class="text-gray-500 text-sm">Pending Updates</div>
				</div>
			</div>
		</div>

		<!-- Recent Activities Card -->
		<div class="bg-white rounded-lg shadow p-6">
			<h3 class="text-lg font-semibold text-green-600 mb-4">Recent Activities</h3>
			<div class="space-y-2">
				<div class="flex items-center">
					<div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
					<div class="text-sm">DEV-001245 updated to v2.4.1</div>
				</div>
				<div class="flex items-center">
					<div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
					<div class="text-sm">DEV-001893 updated to v2.4.1</div>
				</div>
				<div class="flex items-center">
					<div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
					<div class="text-sm">DEV-003421 update failed</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Recent Updates Table -->
	<div class="bg-white rounded-lg shadow overflow-hidden">
		<div class="p-4 border-b border-gray-200">
			<h3 class="text-lg font-semibold text-green-600">Recent Updates</h3>
		</div>
		<div class="overflow-x-auto">
			<table class="min-w-full divide-y divide-gray-200">
				<thead class="bg-gray-50">
					<tr>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device ID
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activity
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
						</th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y divide-gray-200">
					<tr>
						<td class="px-6 py-4 whitespace-nowrap">2023-06-15 14:30</td>
						<td class="px-6 py-4 whitespace-nowrap">DEV-001245</td>
						<td class="px-6 py-4 whitespace-nowrap">Firmware Update to v2.4.1</td>
						<td class="px-6 py-4 whitespace-nowrap">
							<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Success</span>
						</td>
						<td class="px-6 py-4 whitespace-nowrap">
							<button class="text-green-600 hover:text-green-900 mr-2">Details</button>
						</td>
					</tr>
					<tr>
						<td class="px-6 py-4 whitespace-nowrap">2023-06-15 13:45</td>
						<td class="px-6 py-4 whitespace-nowrap">DEV-001893</td>
						<td class="px-6 py-4 whitespace-nowrap">Firmware Update to v2.4.1</td>
						<td class="px-6 py-4 whitespace-nowrap">
							<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Success</span>
						</td>
						<td class="px-6 py-4 whitespace-nowrap">
							<button class="text-green-600 hover:text-green-900 mr-2">Details</button>
						</td>
					</tr>
					<tr>
						<td class="px-6 py-4 whitespace-nowrap">2023-06-15 12:20</td>
						<td class="px-6 py-4 whitespace-nowrap">DEV-003421</td>
						<td class="px-6 py-4 whitespace-nowrap">Firmware Update to v2.4.1</td>
						<td class="px-6 py-4 whitespace-nowrap">
							<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Failed</span>
						</td>
						<td class="px-6 py-4 whitespace-nowrap">
							<button class="text-green-600 hover:text-green-900 mr-2">Details</button>
							<button class="text-blue-600 hover:text-blue-900">Retry</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@endsection