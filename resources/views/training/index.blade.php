@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Data Training</div>
    <div class="card-body">
        <div class="row">
            <form method="POST" enctype="multipart/form-data" action="{{ route('training.submit_excel') }}">
                {{ csrf_field() }}

                @error('excel')
                <div class="form-group">
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ $message }}
                    </div>
                </div>
                @enderror

                <div class="form-group form-inline">
                    <label for="input" class="col-md-3">File Excel</label>
                    <input class="form-control col-md-6 @error('excel') is-invalid @enderror mr-2" type="file" name="excel" />
                    <input type="submit" class="btn btn-success btn-md" />
                </div>
            </form>
        </div>
        <hr>
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