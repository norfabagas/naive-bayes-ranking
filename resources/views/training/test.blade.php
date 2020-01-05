@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Pengujian</div>
    <div class="card-body">
        <form method="GET">
            <div class="form-group form-inline">
                <label for="input" class="col-md-2">Nama</label>
                <input type="text" name="name" value="{{ $_REQUEST['name'] ?? '' }}" class="form-control col-md-10" required>
            </div>

            <div class="form-group form-inline">
                <label for="input" class="col-md-2">TWK</label>
                <select name="twk" class="form-control col-md-4" required>
                    <option value="">-</option>
                    <option value="1" {{ request()->has('twk') ? (request('twk') == 1 ? 'selected' : '') : '' }}>Rendah</option>
                    <option value="2" {{ request()->has('twk') ? (request('twk') == 2 ? 'selected' : '') : '' }}>Sedang</option>
                    <option value="3" {{ request()->has('twk') ? (request('twk') == 3 ? 'selected' : '') : '' }}>Tinggi</option>
                </select>

                <label for="input" class="col-md-2">TIU</label>
                <select name="tiu" class="form-control col-md-4" required>
                    <option value="">-</option>
                    <option value="1" {{ request()->has('tiu') ? (request('tiu') == 1 ? 'selected' : '') : '' }}>Rendah</option>
                    <option value="2" {{ request()->has('tiu') ? (request('tiu') == 2 ? 'selected' : '') : '' }}>Sedang</option>
                    <option value="3" {{ request()->has('tiu') ? (request('tiu') == 3 ? 'selected' : '') : '' }}>Tinggi</option>
                </select>
            </div>

            <div class="form-group form-inline">
                <label for="input" class="col-md-2">TKP</label>
                <select name="tkp" class="form-control col-md-4" required>
                    <option value="">-</option>
                    <option value="1" {{ request()->has('tkp') ? (request('tkp') == 1 ? 'selected' : '') : '' }}>Rendah</option>
                    <option value="2" {{ request()->has('tkp') ? (request('tkp') == 2 ? 'selected' : '') : '' }}>Sedang</option>
                    <option value="3" {{ request()->has('tkp') ? (request('tkp') == 3 ? 'selected' : '') : '' }}>Tinggi</option>
                </select>

                <label for="input" class="col-md-2">TPA</label>
                <select name="tpa" class="form-control col-md-4" required>
                    <option value="">-</option>
                    <option value="1" {{ request()->has('tpa') ? (request('tpa') == 1 ? 'selected' : '') : '' }}>Rendah</option>
                    <option value="2" {{ request()->has('tpa') ? (request('tpa') == 2 ? 'selected' : '') : '' }}>Sedang</option>
                    <option value="3" {{ request()->has('tpa') ? (request('tpa') == 3 ? 'selected' : '') : '' }}>Tinggi</option>
                </select>
            </div>

            <div class="form-group form-inline">
                <label for="input" class="col-md-2">TBI</label>
                <select name="tbi" class="form-control col-md-4" required>
                    <option value="">-</option>
                    <option value="1" {{ request()->has('tbi') ? (request('tbi') == 1 ? 'selected' : '') : '' }}>Rendah</option>
                    <option value="2" {{ request()->has('tbi') ? (request('tbi') == 2 ? 'selected' : '') : '' }}>Sedang</option>
                    <option value="3" {{ request()->has('tbi') ? (request('tbi') == 3 ? 'selected' : '') : '' }}>Tinggi</option>
                </select>

            </div>

            <div class="form-group text-center">
                <hr>
                <input type="submit" class="btn btn-lg btn-success" value="Prediksi">
            </div>
        </form>

        @if (request()->has(['name', 'twk', 'tiu', 'tkp', 'tpa', 'tbi']))
        <table class="table table-hover table-responsive">
            <tr>
                <th>Nama</th>
                <th>TWK</th>
                <th>TIU</th>
                <th>TKP</th>
                <th>TPA</th>
                <th>TBI</th>
                <th>Kelas Prediksi</th>
                <th>Lulus</th>
                <th>Tidak Lulus</th>
            </tr>
            <tr>
                <td>{{ request('name') }}</td>
                <td>{{ $resultDict[request('twk')] }}</td>
                <td>{{ $resultDict[request('tiu')] }}</td>
                <td>{{ $resultDict[request('tkp')] }}</td>
                <td>{{ $resultDict[request('tpa')] }}</td>
                <td>{{ $resultDict[request('tbi')] }}</td>
                <td>{{ $result }}</td>
                <td>{{ $passedPrediction }}%</td>
                <td>{{ $failedPrediction }}%</td>
            </tr>
        </table>
        @endif
    </div>
</div>
@endsection