@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        Statistik : {{ strtoupper($test) }}
        <a class="float-right btn btn-primary" href="{{ route('training.statistic') }}">Kembali</a>
    </div> <!-- card-header -->

    <div class="card-body">
        <table class="table table-hover">
            <tr class="table-primary">
                <th colspan="2">Rendah</th>
            </tr>
            <tr class="table-secondary">
                <th>Lulus</th>
                <th>Tidak</th>
            </tr>
            @for($i = 0; $i < $detailedResults['low_count']; $i++)
            <tr>
                <td>{{ $detailedResults['low_passed'][$i]->name ?? '' }}</td>
                <td>{{ $detailedResults['low_failed'][$i]->name ?? '' }}</td>
            </tr>
            @endfor
            <tr><td></td></tr> <!-- act as separator -->
            
            <tr class="table-primary">
                <th colspan="2">Sedang</th>
            </tr>
            <tr class="table-secondary">
                <th>Lulus</th>
                <th>Tidak</th>
            </tr>
            @for($i = 0; $i < $detailedResults['mid_count']; $i++)
            <tr>
                <td>{{ $detailedResults['mid_passed'][$i]->name ?? '' }}</td>
                <td>{{ $detailedResults['mid_failed'][$i]->name ?? '' }}</td>
            </tr>
            @endfor
            <tr><td></td></tr> <!-- act as separator -->
            
            <tr class="table-primary">
                <th colspan="2">Tinggi</th>
            </tr>
            <tr class="table-secondary">
                <th>Lulus</th>
                <th>Tidak</th>
            </tr>
            @for($i = 0; $i < $detailedResults['high_count']; $i++)
            <tr>
                <td>{{ $detailedResults['high_passed'][$i]->name ?? '' }}</td>
                <td>{{ $detailedResults['high_failed'][$i]->name ?? '' }}</td>
            </tr>
            @endfor
            <tr><td></td></tr> <!-- act as separator -->
        </table>
    </div> <!-- card-body -->
</div> <!-- card -->
@endsection