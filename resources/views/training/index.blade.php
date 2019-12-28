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
            </tr>
            @foreach ($participants as $participant)
            <tr>
                <td>{{ $participant->name }}</td>
                <td>{{ $participant->result->twk_result }}</td>
                <td>{{ $participant->result->tiu_result }}</td>
                <td>{{ $participant->result->tkp_result }}</td>
                <td>{{ $participant->result->tpa_result }}</td>
                <td>{{ $participant->result->tbi_result }}</td>
            </tr>
            @endforeach
        </table>
        <div class="d-flex justify-content-center">
            {{ $participants->links() }}
        </div>
    </div>
</div>
@endsection