@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Statistik</div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-6">
                <table class="table table-hover">
                    <tr>
                        <th>P (Tepat/Terlambat)</th>
                        <th>Lulus</th>
                        <th>Tidak Lulus</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td>{{ $testResult['passed'] * 100 }}%</td>
                        <td>{{ $testResult['failed'] * 100 }}%</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-hover">
                    <tr>
                        <th>
                            <a class="btn btn-primary" href="{{ route('training.statistic.detail', ['twk']) }}">
                                P (TWK)
                            </a>
                        </th>
                        <th>Lulus</th>
                        <th>Tidak Lulus</th>
                    </tr>
                    <tr>
                        <th>Rendah</th>
                        <td>{{ round($twkResult['low_passed'] * 100) }}%</td>
                        <td>{{ round($twkResult['low_failed'] * 100) }}%</td>
                    </tr>
                    <tr>
                        <th>Sedang</th>
                        <td>{{ round($twkResult['mid_passed'] * 100) }}%</td>
                        <td>{{ round($twkResult['mid_failed'] * 100) }}%</td>
                    </tr>
                    <tr>
                        <th>Tinggi</th>
                        <td>{{ round($twkResult['high_passed'] * 100) }}%</td>
                        <td>{{ round($twkResult['high_failed'] * 100) }}%</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <table class="table table-hover">
                    <tr>
                        <th>
                            <a class="btn btn-primary" href="{{ route('training.statistic.detail', ['tiu']) }}">
                                P (TIU)
                            </a>
                        </th>
                        <th>Lulus</th>
                        <th>Tidak Lulus</th>
                    </tr>
                    <tr>
                        <th>Rendah</th>
                        <td>{{ round($tiuResult['low_passed'] * 100) }}%</td>
                        <td>{{ round($tiuResult['low_failed'] * 100) }}%</td>
                    </tr>
                    <tr>
                        <th>Sedang</th>
                        <td>{{ round($tiuResult['mid_passed'] * 100) }}%</td>
                        <td>{{ round($tiuResult['mid_failed'] * 100) }}%</td>
                    </tr>
                    <tr>
                        <th>Tinggi</th>
                        <td>{{ round($tiuResult['high_passed'] * 100) }}%</td>
                        <td>{{ round($tiuResult['high_failed'] * 100) }}%</td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <table class="table table-hover">
                    <tr>
                        <th>
                        <a class="btn btn-primary" href="{{ route('training.statistic.detail', ['tkp']) }}">
                            P (TKP)
                        </a>
                        </th>
                        <th>Lulus</th>
                        <th>Tidak Lulus</th>
                    </tr>
                    <tr>
                        <th>Rendah</th>
                        <td>{{ round($tkpResult['low_passed'] * 100) }}%</td>
                        <td>{{ round($tkpResult['low_failed'] * 100) }}%</td>
                    </tr>
                    <tr>
                        <th>Sedang</th>
                        <td>{{ round($tkpResult['mid_passed'] * 100) }}%</td>
                        <td>{{ round($tkpResult['mid_failed'] * 100) }}%</td>
                    </tr>
                    <tr>
                        <th>Tinggi</th>
                        <td>{{ round($tkpResult['high_passed'] * 100) }}%</td>
                        <td>{{ round($tkpResult['high_failed'] * 100) }}%</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <table class="table table-hover">
                    <tr>
                        <th>
                            <a class="btn btn-primary" href="{{ route('training.statistic.detail', ['tpa']) }}">
                                P (TPA)
                            </a>
                        </th>
                        <th>Lulus</th>
                        <th>Tidak Lulus</th>
                    </tr>
                    <tr>
                        <th>Rendah</th>
                        <td>{{ round($tpaResult['low_passed'] * 100) }}%</td>
                        <td>{{ round($tpaResult['low_failed'] * 100) }}%</td>
                    </tr>
                    <tr>
                        <th>Sedang</th>
                        <td>{{ round($tpaResult['mid_passed'] * 100) }}%</td>
                        <td>{{ round($tpaResult['mid_failed'] * 100) }}%</td>
                    </tr>
                    <tr>
                        <th>Tinggi</th>
                        <td>{{ round($tpaResult['high_passed'] * 100) }}%</td>
                        <td>{{ round($tpaResult['high_failed'] * 100) }}%</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-hover">
                    <tr>
                        <th>
                            <a class="btn btn-primary" href="{{ route('training.statistic.detail', ['tbi']) }}">
                                P (TBI)
                            </a>
                        </th>
                        <th>Lulus</th>
                        <th>Tidak Lulus</th>
                    </tr>
                    <tr>
                        <th>Rendah</th>
                        <td>{{ round($tbiResult['low_passed'] * 100) }}%</td>
                        <td>{{ round($tbiResult['low_failed'] * 100) }}%</td>
                    </tr>
                    <tr>
                        <th>Sedang</th>
                        <td>{{ round($tbiResult['mid_passed'] * 100) }}%</td>
                        <td>{{ round($tbiResult['mid_failed'] * 100) }}%</td>
                    </tr>
                    <tr>
                        <th>Tinggi</th>
                        <td>{{ round($tbiResult['high_passed'] * 100) }}%</td>
                        <td>{{ round($tbiResult['high_failed'] * 100) }}%</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection