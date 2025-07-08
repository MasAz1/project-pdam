@extends('layouts.app')

@section('title', 'Firmware Upload')
@section('header', 'Firmware Upload')

@section('content')
	<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
		<!-- Upload Form -->
		<div class="bg-white rounded-lg shadow p-6">
			<h3 class="text-lg font-semibold text-green-600 mb-4">Upload New Firmware</h3>
			<form action="{{ route('firmware.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="mb-4">
					<label for="name" class="block text-sm font-medium text-gray-700 mb-1">Firmware Name</label>
					<input type="text" id="name" name="name"
						class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
						placeholder="Enter firmware name">
				</div>

				<div class="mb-4">
					<label for="version" class="block text-sm font-medium text-gray-700 mb-1">Version</label>
					<input type="text" id="version" name="version"
						class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
						placeholder="e.g. 2.4.1">
				</div>

				<div class="mb-4">
					<label for="device_model" class="block text-sm font-medium text-gray-700 mb-1">Device Model</label>
					<select id="device_model" name="device_model"
						class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
						<option value="">Select device model</option>
						<option value="model-a">Model A</option>
						<option value="model-b">Model B</option>
						<option value="model-c">Model C</option>
					</select>
				</div>

				<div class="mb-4">
					<label for="release_notes" class="block text-sm font-medium text-gray-700 mb-1">Release Notes</label>
					<textarea id="release_notes" name="release_notes" rows="4"
						class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
						placeholder="Enter release notes"></textarea>
				</div>

				<div class="mb-4">
					<label class="block text-sm font-medium text-gray-700 mb-1">Firmware File</label>
					<div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md cursor-pointer"
						id="file-upload-container">
						<div class="space-y-1 text-center" id="file-upload-prompt">
							<svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
								viewBox="0 0 48 48" aria-hidden="true">
								<path
									d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
									stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
							<div class="flex text-sm text-gray-600">
								<label for="file-upload"
									class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none">
									<span>Upload a file</span>
									<input id="file-upload" name="firmware_file" type="file" class="sr-only"
										accept=".bin,.hex">
								</label>
								<p class="pl-1">or drag and drop</p>
							</div>
							<p class="text-xs text-gray-500">BIN or HEX files up to 10MB</p>
						</div>
						<div class="hidden" id="file-selected">
							<div class="flex items-center">
								<i class="fas fa-file-alt text-green-500 text-2xl mr-2"></i>
								<span id="file-name" class="font-medium"></span>
							</div>
							<button type="button" id="change-file"
								class="mt-2 text-sm text-green-600 hover:text-green-500">Change file</button>
						</div>
					</div>
				</div>

				<div class="flex space-x-3">
					<button type="submit"
						class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
						Upload Firmware
					</button>
					<button type="reset"
						class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
						Cancel
					</button>
				</div>
			</form>
		</div>

		<!-- Firmware Versions List -->
		<div class="bg-white rounded-lg shadow overflow-hidden">
			<div class="p-4 border-b border-gray-200">
				<h3 class="text-lg font-semibold text-green-600">Available Firmware Versions</h3>
			</div>
			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="bg-gray-50">
						<tr>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
								Version</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
								Device Model</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File
								Name</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
								Upload Date</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
								Actions</th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y divide-gray-200">
						<tr>
							<td class="px-6 py-4 whitespace-nowrap">2.4.1</td>
							<td class="px-6 py-4 whitespace-nowrap">Model A</td>
							<td class="px-6 py-4 whitespace-nowrap">firmware_A_v2.4.1.bin</td>
							<td class="px-6 py-4 whitespace-nowrap">2023-06-10</td>
							<td class="px-6 py-4 whitespace-nowrap">
								<a href="#" class="text-green-600 hover:text-green-900 mr-2">Download</a>
								<a href="#" class="text-red-600 hover:text-red-900">Delete</a>
							</td>
						</tr>
						<tr>
							<td class="px-6 py-4 whitespace-nowrap">2.3.5</td>
							<td class="px-6 py-4 whitespace-nowrap">Model B</td>
							<td class="px-6 py-4 whitespace-nowrap">firmware_B_v2.3.5.bin</td>
							<td class="px-6 py-4 whitespace-nowrap">2023-05-28</td>
							<td class="px-6 py-4 whitespace-nowrap">
								<a href="#" class="text-green-600 hover:text-green-900 mr-2">Download</a>
								<a href="#" class="text-red-600 hover:text-red-900">Delete</a>
							</td>
						</tr>
						<tr>
							<td class="px-6 py-4 whitespace-nowrap">2.2.0</td>
							<td class="px-6 py-4 whitespace-nowrap">Model C</td>
							<td class="px-6 py-4 whitespace-nowrap">firmware_C_v2.2.0.bin</td>
							<td class="px-6 py-4 whitespace-nowrap">2023-04-15</td>
							<td class="px-6 py-4 whitespace-nowrap">
								<a href="#" class="text-green-600 hover:text-green-900 mr-2">Download</a>
								<a href="#" class="text-red-600 hover:text-red-900">Delete</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	@section('scripts')
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				const fileInput = document.getElementById('file-upload');
				const fileUploadContainer = document.getElementById('file-upload-container');
				const fileUploadPrompt = document.getElementById('file-upload-prompt');
				const fileSelected = document.getElementById('file-selected');
				const fileName = document.getElementById('file-name');
				const changeFileBtn = document.getElementById('change-file');

				fileInput.addEventListener('change', function (e) {
					if (e.target.files.length > 0) {
						fileName.textContent = e.target.files[0].name;
						fileUploadPrompt.classList.add('hidden');
						fileSelected.classList.remove('hidden');
					}
				});

				changeFileBtn.addEventListener('click', function () {
					fileInput.value = '';
					fileUploadPrompt.classList.remove('hidden');
					fileSelected.classList.add('hidden');
				});

				// Handle drag and drop
				fileUploadContainer.addEventListener('dragover', function (e) {
					e.preventDefault();
					fileUploadContainer.classList.add('border-green-500');
				});

				fileUploadContainer.addEventListener('dragleave', function () {
					fileUploadContainer.classList.remove('border-green-500');
				});

				fileUploadContainer.addEventListener('drop', function (e) {
					e.preventDefault();
					fileUploadContainer.classList.remove('border-green-500');

					if (e.dataTransfer.files.length > 0) {
						fileInput.files = e.dataTransfer.files;
						fileName.textContent = e.dataTransfer.files[0].name;
						fileUploadPrompt.classList.add('hidden');
						fileSelected.classList.remove('hidden');
					}
				});
			});
		</script>
	@endsection
@endsection