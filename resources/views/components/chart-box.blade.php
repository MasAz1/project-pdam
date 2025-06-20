<!-- resources/views/components/chart-box.blade.php -->
@props(['title', 'chartId'])

<div class="bg-[#112240] p-4 rounded shadow-md">
    <h2 class="text-lg font-bold text-blue-300 mb-2">{{ $title }}</h2>
    <canvas id="{{ $chartId }}" height="200"></canvas>
</div>
