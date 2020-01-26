@extends('layouts.app')

@section('title', 'Training overview')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Training overview</h1>

<div class="row">

    <div class="col-xl-12 col-md-12 mb-12">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-white">Open training requests</h6> 
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover table-leftpadded mb-0" width="100%" cellspacing="0"
                        data-toggle="table"
                        data-pagination="true"
                        data-strict-search="true"
                        data-filter-control="true">
                        <thead class="thead-light">
                            <tr>
                                <th data-sortable="true" data-filter-control="select">State</th>
                                <th data-sortable="true" data-filter-control="input" data-visible-search="true">Vatsim ID</th>
                                <th data-sortable="true" data-filter-control="input">Name</th>
                                <th data-sortable="true" data-filter-control="select" data-filter-strict-search="true">Level</th>
                                <th data-sortable="true" data-filter-control="select">Type</th>
                                <th data-sortable="true" data-filter-control="input">Period</th>
                                <th data-sortable="true" data-filter-control="select">Country</th>
                                <th data-sortable="true" data-filter-control="input">Applied</th>
                                <th data-sortable="true" data-filter-control="select">Mentor</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($openTrainings as $training)
                            <tr>
                                <td>
                                    <i class="{{ $statuses[$training->status]["icon"] }} text-{{ $statuses[$training->status]["color"] }}"></i>&ensp;<a href="/training/{{ $training->id }}">{{ $statuses[$training->status]["text"] }}</a>
                                </td>
                                <td><a href="/user/{{ $training->user->id }}">{{ $training->user->id }}</a></td>
                                <td><a href="/user/{{ $training->user->id }}">{{ $training->user->handover->firstName }} {{ $training->user->handover->lastName }}</a></td>
                                <td>
                                    @if ( is_iterable($ratings = $training->ratings->toArray()) )
                                        @for( $i = 0; $i < sizeof($ratings); $i++ )
                                            @if ( $i == (sizeof($ratings) - 1) )
                                                {{ $ratings[$i]["name"] }}
                                            @else
                                                {{ $ratings[$i]["name"] . " + " }}
                                            @endif
                                        @endfor
                                    @else
                                        {{ $ratings["name"] }}
                                    @endif
                                </td>
                                <td>
                                    <i class="{{ $types[$training->type]["icon"] }}"></i>&ensp;{{ $types[$training->type]["text"] }}
                                </td>
                                <td>
                                    @if ($training->started_at == null && $training->finished_at == null)
                                        Training not started
                                    @elseif ($training->finished_at == null)
                                        {{ $training->started_at->toFormattedDateString() }} -
                                    @else
                                        {{ $training->started_at->toFormattedDateString() }} - {{ $training->finished_at->toFormattedDateString() }}
                                    @endif
                                </td>
                                <td>{{ $training->country->name }}</td>
                                <td>{{ $training->created_at->toFormattedDateString() }}</td>
                                <td>
                                    @if ( is_iterable($mentors = $training->mentors->toArray()) )
                                        @if (sizeof($mentors) == 0)
                                            -
                                        @else
                                            @for( $i = 0; $i < sizeof($mentors); $i++ )
                                                @if ( $i == (sizeof($mentors) - 1) )
                                                    {{ $mentors[$i]["name"] }}
                                                @else
                                                    {{ $mentors[$i]["name"] . ", " }}
                                                @endif
                                            @endfor
                                        @endif
                                    @else
                                        {{ $mentors[$i]["name"] }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-md-12 mb-12">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-white">Closed training requests</h6> 
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-sm table-hover table-leftpadded mb-0" width="100%" cellspacing="0"
                        data-toggle="table"
                        data-pagination="true"
                        data-strict-search="true"
                        data-filter-control="true">
                        <thead class="thead-light">
                            <tr>
                                <th data-sortable="true" data-filter-control="select">State</th>
                                <th data-sortable="true" data-filter-control="input" data-visible-search="true">Vatsim ID</th>
                                <th data-sortable="true" data-filter-control="input">Name</th>
                                <th data-sortable="true" data-filter-control="select" data-filter-strict-search="true">Level</th>
                                <th data-sortable="true" data-filter-control="select">Type</th>
                                <th data-sortable="true" data-filter-control="input">Period</th>
                                <th data-sortable="true" data-filter-control="select">Country</th>
                                <th data-sortable="true" data-filter-control="input">Applied</th>
                                <th data-sortable="true" data-filter-control="input">Closed</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($closedTrainings as $training)
                            <tr>
                                <td>
                                    <i class="{{ $statuses[$training->status]["icon"] }} text-{{ $statuses[$training->status]["color"] }}"></i>&ensp;<a href="/training/{{ $training->id }}">{{ $statuses[$training->status]["text"] }}</a>
                                </td>
                                <td><a href="/user/{{ $training->user->id }}">{{ $training->user->id }}</a></td>
                                <td><a href="/user/{{ $training->user->id }}">{{ $training->user->handover->firstName }} {{ $training->user->handover->lastName }}</a></td>
                                <td>
                                    @if ( is_iterable($ratings = $training->ratings->toArray()) )
                                        @for( $i = 0; $i < sizeof($ratings); $i++ )
                                            @if ( $i == (sizeof($ratings) - 1) )
                                                {{ $ratings[$i]["name"] }}
                                            @else
                                                {{ $ratings[$i]["name"] . " + " }}
                                            @endif
                                        @endfor
                                    @else
                                        {{ $ratings["name"] }}
                                    @endif
                                </td>
                                <td>
                                    <i class="{{ $types[$training->type]["icon"] }}"></i>&ensp;{{ $types[$training->type]["text"] }}     
                                </td>
                                <td>
                                    @if ($training->started_at == null && $training->finished_at == null)
                                        Training never started
                                    @elseif ($training->finished_at == null)
                                        {{ $training->started_at->toFormattedDateString() }} -
                                    @else
                                        {{ $training->started_at->toFormattedDateString() }} - {{ $training->finished_at->toFormattedDateString() }}
                                    @endif
                                </td>
                                <td>{{ $training->country->name }}</td>
                                <td>{{ $training->created_at->toFormattedDateString() }}</td>
                                <td>{{ $training->finished_at->toFormattedDateString() }}</td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
<script>
    //Activate bootstrap tooltips
    $(document).ready(function() {
        $('div').tooltip();
    })
</script>
@endsection