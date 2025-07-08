@extends('layouts.app')

@section('title', 'Firmware Update')
@section('header', 'Firmware Update')

@section('content')
	<!-- Update Form -->
	<div class="bg-white rounded-lg shadow p-6 mb-6">
		<h3 class="text-lg font-semibold text-green-600 mb-4">Update Devices</h3>
		<form>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
				<div>
					<label for="device_group" class="block text-sm font-medium text-gray-700 mb-1">Device Group</label>
					<select id="device_group"
						class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
						<option value="">All Devices</option>
						<option value="group1">Office Devices</option>
						<option value="group2">Warehouse Devices</option>
						<option value="group3">Retail Devices</option>
					</select>
				</div>

				<div>
					<label for="device_model" class="block text-sm font-medium text-gray-700 mb-1">Device Model</label>
					<select id="device_model"
						class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
						<option value="">All Models</option>
						<option value="model-a">Model A</option>
						<option value="model-b">Model B</option>
						<option value="model-c">Model C</option>
					</select>
				</div>

				<div>
					<label for="firmware_version" class="block text-sm font-medium text-gray-700 mb-1">Firmware
						Version</label>
					<select id="firmware_version"
						class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
						<option value="">Select firmware version</option>
						<option value="2.4.1">v2.4.1 (Latest)</option>
						<option value="2.3.5">v2.3.5</option>
						<option value="2.2.0">v2.2.0</option>
					</select>
				</div>
			</div>

			<div class="mb-4">
				<label class="inline-flex items-center">
					<input type="checkbox"
						class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
					<span class="ml-2">Schedule Update</span>
				</label>
			</div>

			<div class="flex space-x-3">
				<button type="submit"
					class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
					Start Update
				</button>
				<button type="reset"
					class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
					Reset
				</button>
			</div>
		</form>
	</div>

	<!-- Update Progress -->
	<div class="bg-white rounded-lg shadow p-6 mb-6">
		<h3 class="text-lg font-semibold text-green-600 mb-2">Update Progress</h3>
		<div class="w-full bg-gray-200 rounded-full h-4 mb-2">
			<div id="update-progress"
				class="bg-green-600 h-4 rounded-full text-xs text-white flex items-center justify-center" style="width: 0%">
				0%</div>
		</div>
		<div class="text-right text-sm text-gray-500">Updated 24 of 142 devices</div>
	</div>

	<!-- Device List -->
	<div class="bg-white rounded-lg shadow overflow-hidden">
		<div class="p-4 border-b border-gray-200 flex justify-between items-center">
			<h3 class="text-lg font-semibold text-green-600">Device List</h3>
			<div class="flex space-x-2">
				<input type="text" placeholder="Search devices..."
					class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
				<select
					class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
					<option>All Status</option>
					<option>Pending</option>
					<option>Success</option>
					<option>Failed</option>
				</select>
			</div>
		</div>
		<div class="overflow-x-auto">
			<table class="min-w-full divide-y divide-gray-200">
				<thead class="bg-gray-50">
					<tr>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device ID
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current
							Version</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target
							Version</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
						</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last
							Check</th>
						<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
						</th>
					</tr>
				</thead>
				<tbody class="bg-white divide-y divide-gray-200">
					<tr>
						<td class="px-6 py-4 whitespace-nowrap">DEV-001245</td>
						<td class="px-6 py-4 whitespace-nowrap">Model A</td>
						<td class="px-6 py-4 whitespace-nowrap">2.3.5</td>
						<td class="px-6 py-4 whitespace-nowrap">2.4.1</td>
						<td class="px-6 py-4 whitespace-nowrap">
							<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Success</span>
						</td>
						<td class="px-6 py-4 whitespace-nowrap">2023-06-15 14:30</td>
						<td class="px-6 py-4 whitespace-nowrap">
							<button class="text-green-600 hover:text-green-900 mr-2">Details</button>
						</td>
					</tr>
					<tr>
						<td class="px-6 py-4 whitespace-nowrap">DEV-001893</td>
						<td class="px-6 py-4 whitespace-nowrap">Model B</td>
						<td class="px-6 py-4 whitespace-nowrap">2.2.0</td>
						<td class="px-6 py-4 whitespace-nowrap">2.4.1</td>
						<td class="px-6 py-4 whitespace-nowrap">
							<span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Success</span>
						</td>
						<td class="px-6 py-4 whitespace-nowrap">2023-06-15 13:45</td>
						<td class="px-6 py-4 whitespace-nowrap">
							<button class="text-green-600 hover:text-green-900 mr-2">Details</button>
						</td>
					</tr>
					<tr>
						<td class="px-6 py-4 whitespace-nowrap">DEV-003421</td>
						<td class="px-6 py-4 whitespace-nowrap">Model A</td>
						<td class="px-6 py-4 whitespace-nowrap">2.3.5</td>
						<td class="px-6 py-4 whitespace-nowrap">2.4.1</td>
						<td class="px-6 py-4 whitespace-nowrap">
							<span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Failed</span>
						</td>
						<td class="px-6 py-4 whitespace-nowrap">2023-06-15 12:20</td>
						<td class="px-6 py-4 whitespace-nowrap">
							<button class="text-green-600 hover:text-green-900 mr-2">Details</button>
							<button class="text-blue-600 hover:text-blue-900">Retry</button>
						</td>
					</tr>
					<tr>
						<td class="px-6 py-4 whitespace-nowrap">DEV-002567</td>
						<td class="px-6 py-4 whitespace-nowrap">Model C</td>
						<td class="px-6 py-4 whitespace-nowrap">2.1.0</td>
						<td class="px-6 py-4 whitespace-nowrap">2.4.1</td>
						<td class="px-6 py-4 whitespace-nowrap">
							<span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
						</td>
						<td class="px-6 py-4 whitespace-nowrap">2023-06-15 11:05</td>
						<td class="px-6 py-4 whitespace-nowrap">
							<button class="text-green-600 hover:text-green-900 mr-2">Details</button>
							<button class="text-blue-600 hover:text-blue-900">Retry</button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	@section('scripts')
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				// Simulate progress update
				let progress = 0;
				const progressBar = document.getElementById('update-progress');

				const progressInterval = setInterval(() => {
					progress += 5;
					if (progress > 65) {
						progress = 65;
						clearInterval(progressInterval);
					}
					progressBar.style.width = `${progress}%`;
					progressBar.textContent = `${progress}%`;
				}, 500);
			});
		</script>
	@endsection
@endsection