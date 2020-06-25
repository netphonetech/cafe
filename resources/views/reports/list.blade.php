@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">List of reports
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                        data-target="#modal-add">
                        Add new report
                    </button>
                </div>

                <div class="card-body">
                    @if (!$reports->first())
                    <h3 class="text-center">No report added yet</h3>
                    @else
                    <table class="table table-bordered table-striped table-responsive table-sm" id="">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                {{-- <th>Expected</th>
                                <th>Actual</th> --}}
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $sno=1;
                            @endphp
                            @foreach ($reports as $report)
                            <tr>
                                <td>@php
                                    echo $sno;$sno++;
                                    @endphp
                                </td>
                                <td>{{$report->date}}</td>
                                {{-- <td class="text-right">{{number_format(($report->expected),2,'.',',')}}</td>
                                <td class="text-right">{{number_format(($report->actual_amount),2,'.',',')}}</td> --}}
                                <td class="text-center">
                                    <a href="{{ route('report-items',['report'=>$report->id])}}" type="button"
                                        class="btn btn-info btn-sm">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start Modal Add -->
<div class="modal fade" id="modal-add" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="modal-addLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-addLabel">Add date and actual amount to proceed</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('report-add') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Report Date') }}</label>

                        <div class="col-md-8">
                            <input id="date" type="date" class="form-control @error('date') is-invalid @enderror"
                                name="date" value="{{ old('date') }}" required autocomplete="date" autofocus>

                            @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="amount"
                            class="col-md-4 col-form-label text-md-right">{{ __('Actual Amount') }}</label>

                        <div class="col-md-8">
                            <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror"
                                name="amount" value="{{ old('amount') }}" autocomplete="amount">

                            @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Proceed ..') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Add -->
@endsection