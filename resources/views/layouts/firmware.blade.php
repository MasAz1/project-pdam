<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Device Management - @yield('title')</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
	<div class="flex h-screen">
		<!-- Sidebar -->
		<div class="w-64 bg-gray-800 text-white fixed h-full">
			<div class="p-4 border-b border-gray-700">
				<h1 class="text-xl font-bold">Device Management</h1>
			</div>
			<nav class="mt-4">
				<ul>
					<li class="px-4 py-2 hover:bg-gray-700 {{ request()->is('dashboard') ? 'bg-gray-700' : '' }}">
						<a href="{{ route('dashboard') }}" class="block">
							<i class="fas fa-tachometer-alt mr-2"></i> Dashboard
						</a>
					</li>
					<li class="px-4 py-2 hover:bg-gray-700 {{ request()->is('devices') ? 'bg-gray-700' : '' }}">
						<a href="{{ route('devices.index') }}" class="block">
							<i class="fas fa-microchip mr-2"></i> Devices
						</a>
					</li>
					<li class="px-4 py-2 hover:bg-gray-700 {{ request()->is('firmware/upload') ? 'bg-gray-700' : '' }}">
						<a href="{{ route('firmware.upload') }}" class="block">
							<i class="fas fa-upload mr-2"></i> Firmware Upload
						</a>
					</li>
					<li class="px-4 py-2 hover:bg-gray-700 {{ request()->is('firmware/update') ? 'bg-gray-700' : '' }}">
						<a href="{{ route('firmware.update') }}" class="block">
							<i class="fas fa-sync-alt mr-2"></i> Firmware Update
						</a>
					</li>
					<li class="px-4 py-2 hover:bg-gray-700 {{ request()->is('history') ? 'bg-gray-700' : '' }}">
						<a href="{{ route('history.index') }}" class="block">
							<i class="fas fa-history mr-2"></i> Update History
						</a>
					</li>
					<li class="px-4 py-2 hover:bg-gray-700 {{ request()->is('users*') ? 'bg-gray-700' : '' }}">
						<a href="{{ route('users.index') }}" class="block">
							<i class="fas fa-users mr-2"></i> User Management
						</a>
					</li>
					<li class="px-4 py-2 hover:bg-gray-700 {{ request()->is('settings') ? 'bg-gray-700' : '' }}">
						<a href="{{ route('settings.index') }}" class="block">
							<i class="fas fa-cog mr-2"></i> Settings
						</a>
					</li>
					<li class="px-4 py-2 hover:bg-gray-700">
						<form method="POST" action="{{ route('logout') }}">
							@csrf
							<button type="submit" class="w-full text-left">
								<i class="fas fa-sign-out-alt mr-2"></i> Logout
							</button>
						</form>
					</li>
				</ul>
			</nav>
		</div>

		<!-- Main Content -->
		<div class="flex-1 ml-64">
			<!-- Header -->
			<header class="bg-white shadow-sm p-4 flex justify-between items-center">
				<h2 class="text-xl font-semibold">@yield('header')</h2>
				<div class="flex items-center space-x-2">
					<img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="User"
						class="w-8 h-8 rounded-full">
					<span>{{ auth()->user()->name }}</span>
				</div>
			</header>

			<!-- Content -->
			<main class="p-4">
				@yield('content')
			</main>
		</div>
	</div>

	@yield('scripts')
</body>

</html>