@php use \Illuminate\Support\Str; @endphp

<div class="p-6 bg-white rounded-lg shadow text-sm text-gray-800 space-y-6">

    <div>
        <h2 class="text-lg font-bold"> Request</h2>
        <p>{{ $exception->request()->method() }} <span class="text-gray-500">{{ Str::start($exception->request()->path(), '/') }}</span></p>
    </div>

    <div>
        <h2 class="text-lg font-bold"> Headers</h2>
        <ul class="bg-gray-100 rounded p-4 text-xs overflow-x-auto space-y-1">
            @forelse($exception->requestHeaders() as $key => $value)
            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
            @empty
            <li class="text-gray-400">No headers data</li>
            @endforelse
        </ul>
    </div>

    <div>
        <h2 class="text-lg font-bold"> Body</h2>
        <pre class="bg-gray-100 rounded p-4 text-xs overflow-x-auto">{{ $exception->requestBody() ?: 'No body data' }}</pre>
    </div>

    <div>
        <h2 class="text-lg font-bold"> Routing</h2>
        <ul class="bg-gray-100 rounded p-4 text-xs overflow-x-auto space-y-1">
            @forelse($exception->applicationRouteContext() as $name => $value)
            <li><strong>{{ $name }}:</strong> {{ $value }}</li>
            @empty
            <li class="text-gray-400"> No routing data</li>
            @endforelse
        </ul>
    </div>

    @if($routeParametersContext = $exception->applicationRouteParametersContext())
    <div>
        <h2 class="text-lg font-bold"> Routing Parameters</h2>
        <pre class="bg-gray-100 rounded p-4 text-xs overflow-x-auto">{{ $routeParametersContext }}</pre>
    </div>
    @endif

    <div>
        <h2 class="text-lg font-bold"> Database Queries</h2>
        <ul class="bg-gray-100 rounded p-4 text-xs overflow-x-auto space-y-2">
            @forelse($exception->applicationQueries() as ['connectionName' => $connectionName, 'sql' => $sql, 'time' => $time])
            <li>
                <div><strong>{{ $connectionName }}</strong> ({{ $time }} ms)</div>
                <div class="text-gray-700">{{ $sql }}</div>
            </li>
            @empty
            <li class="text-gray-400"> No query data</li>
            @endforelse
        </ul>
    </div>

</div>