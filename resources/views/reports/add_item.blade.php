@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List of items
                    <a href="{{ route('print-report',['id'=>$report->id]) }}"
                        class="btn btn-success float-right">Print</a>
                </div>

                <div class="card-body row">
                    <div class="col-md-8">
                        <button type="button" class="btn btn-primary btn-sm float-right form-group" data-toggle="modal"
                            data-target="#modal-add">
                            Add item
                        </button>
                        @if (!$report_items->first())
                        <h3 class="text-center">No item added yet</h3>
                        @else
                        <table class="table table-bordered table-striped table-sm" id="">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>Portions</th>
                                    <th>price</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $sno=1;
                                $total=0;
                                @endphp
                                @foreach ($report_items as $report_item)
                                <tr>
                                    <td>@php
                                        echo $sno;
                                        $sno++;
                                        $subtotal=$report_item->price*$report_item->portions;
                                        $total+=$subtotal
                                        @endphp
                                    </td>
                                    <td>{{$report_item->item}}</td>
                                    <td>{{$report_item->portions}}</td>
                                    <td class="text-right">
                                        {{number_format(($report_item->price),2,'.',',')}}
                                    </td>
                                    <td class="text-right">
                                        {{number_format(($subtotal),2,'.',',')}}
                                    </td>
                                    <td>
                                        <form action="{{ route('report-item-destroy')}}" method="post"
                                            onsubmit="return confirm('delete this item?')">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$report_item->id}}">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="text-right">
                                <tr>
                                    <th colspan="4">TOTAL</th>
                                    <th>{{number_format($total,2,'.',',')}}</th>
                                </tr>
                            </tfoot>
                        </table>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <h3>REPORT OF {{$report->date}}</h3>
                        <hr>
                        <ul>
                            <li>
                                <h5>Expected amount: {{number_format($total??0,2,'.',',')}}
                                </h5>
                            </li>
                            <li>
                                <h5>Actual amount : {{number_format($report->actual_amount,2,'.',',') }}
                                </h5>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start Modal Add -->
<div class="modal show" id="modal-add" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="modal-addLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-addLabel">Add report item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('report-item-add') }}">
                    @csrf
                    <input type="hidden" name="report_id" value="{{$report->id}}">
                    <div class="form-group row">
                        <label for="item" class="col-md-4 col-form-label text-md-right">{{ __('Item') }}</label>

                        <div class="col-md-8">
                            <select id="item" class="form-control @error('item') is-invalid @enderror" name="item"
                                required autofocus>
                                <option selected value=""> -- </option>
                                @foreach ($items as $item)
                                <option value="{{$item->id}}" title="{{$item->unit_measure}}">{{$item->item}}</option>
                                @endforeach
                            </select>

                            @error('item')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="quantity"
                            class="col-md-4 col-form-label text-md-right">{{ __('Amount Used') }}</label>

                        <div class="col-md-4">
                            <input id="quantity" type="text" name="quantity" required autocomplete="current-quantity"
                                class="form-control @error('quantity') is-invalid @enderror">

                            @error('quantity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div><label for="unit_measure" id="unit_measure" class="col-form-label text-md-left"></label>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Save Item') }}
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