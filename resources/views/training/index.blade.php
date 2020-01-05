@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Data Training</div>
    <div class="card-body">
        <table class="table table-responsive table-hover">
            <tr>
                <th>Nama</th>
                <th>TWK</th>
                <th>TIU</th>
                <th>TKP</th>
                <th>TPA</th>
                <th>TBI</th>
                <th>Hasil</th>
            </tr>
            @foreach ($participants as $participant)
            <tr>
                <td>{{ $participant->name }}</td>
                <td>{{ $participant->results()->first()->twk_result }}</td>
                <td>{{ $participant->results()->first()->tiu_result }}</td>
                <td>{{ $participant->results()->first()->tkp_result }}</td>
                <td>{{ $participant->results()->first()->tpa_result }}</td>
                <td>{{ $participant->results()->first()->tbi_result }}</td>
                <td>{{ $participant->results()->first()->test_result }}</td>
            </tr>
            @endforeach
        </table>
        <div class="d-flex justify-content-center">
            {{ $participants->links() }}
        </div>
    </div>
</div>
@endsection