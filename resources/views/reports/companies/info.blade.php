@extends("layouts.reports")

@section('content')

<h2>{{ $company->name }}</h2>
{{-- <small><pre>{{ $company->description }}</pre></small> --}}

<div>
    <b>Main contacts and info</b>
    <ul class="list-unstyled">
        @if(!empty($company->website))
            <li>
                <a href="{{ URL::to($company->website) }}" target="_blank"><i class="fa fa-external-link"></i> {{ $company->website }}</a>
            </li>
        @endif
        @if(!empty($company->contactName))
            <li><i class="fa fa-user"></i> {{ $company->contactName }}</li>
        @endif
        @if(!empty($company->tel))
            <li><a href="tel:+39{{$company->tel}}"><i class="fa fa-phone"></i> {{ $company->tel }}</a></li>
        @endif
        @if(!empty($company->email))
            <li><a href="mailto:{{ $company->email }}"><i class="fa fa-envelope"></i> {{ $company->email }}</a></li>
        @endif
        @if(!empty($company->pec))
            <li><a href="mailto:{{ $company->pec }}"><i class="fa fa-envelope-square"></i> {{ $company->pec }}</a></li>
        @endif
        @if(!empty($company->skype))
            <li><a href="skype:{{$company->skype}}?chat"><i class="fa fa-skype"></i> {{ $company->skype }}</a></li>
        @endif
    </ul>
</div>


<table style="width: 100%; background-color: #f7f8f5; border: 1px solid black" cellpadding="2" cellspacing="0">
    <tr>
        <th style="background-color: #f1f2ef; border: 1px solid #3f3f3e;" colspan="4">Project list</th>
    </tr>
    <thead>
    <tr>
        <th style="border-right: 1px solid #3f3f3e; border-bottom: 1px solid #3f3f3e; ">Title</th>
        <th align="center" style="border-right: 1px solid #3f3f3e; border-bottom: 1px solid #3f3f3e; ">Tasks</th>
        <th align="center" style="border-right: 1px solid #3f3f3e; border-bottom: 1px solid #3f3f3e; ">Created at</th>
        <th align="center" style=" border-bottom: 1px solid #3f3f3e; ">Last updated</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $counter = 0;
    ?>
    @foreach($company->projects as $project)
        <?php
        $bgcolor = ($counter === 0) ? "white" : "#f7f8f5";
        $counter = ($counter === 0) ? 1 : 0;
        ?>
    <tr>
        <td style="background-color: <?=$bgcolor?>; border-right: 1px solid #3f3f3e; border-bottom: 1px solid #3f3f3e; width: 40%">{{ $project->name }}</td>
        <td align="center" style="background-color: <?=$bgcolor?>; border-right: 1px solid #3f3f3e; border-bottom: 1px solid #3f3f3e; width: 10%">{{ $project->tasks_count() }}</td>
        <td align="center" style="background-color: <?=$bgcolor?>; border-right: 1px solid #3f3f3e; border-bottom: 1px solid #3f3f3e; width: 25%">{{ $project->created_at->format("d/m/Y H:i:s") }}</td>
        <td align="center" style="background-color: <?=$bgcolor?>; border-bottom: 1px solid #3f3f3e; width: 25%">{{ $project->updated_at->format("d/m/Y H:i:s") }}</td>
    </tr>
    </tbody>
    @endforeach
</table>

@endsection