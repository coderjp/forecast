<link href="{{ asset('vendor/forecast/app.css') }}" rel="stylesheet" />

@if ($forecast)
    <p>5 Day Forecast for {{ $forecast->city }}, {{ $forecast->country }} ({{ $ip }})</p>
    <div class="forecast-container">
        @foreach ($forecast->days as $day)
            <div class="forecast-day">
                <div class="strong">{{ $day->date->format('D') }}</div>
                <div><img src="{{ asset('vendor/forecast/images/' . $day->code . '.png') }}" title="{{$day->code}}" alt="{{$day->code}}"/></div>
                <div>{{ $day->temperature }}&deg;C</div>
            </div>
        @endforeach
    </div>
@else
    <div class="error">Failed to get forecast for '{{ $ip }}''.</div>
@endif

<form method="POST">
    <label>Enter an IP address to lookup</label>
    <input type="text" name="ip" value="{{ request()->old('ip', $ip) }}"/>
    <button>Lookup!</button>
</form>