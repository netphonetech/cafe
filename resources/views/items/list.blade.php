@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">List of items
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-add">
                        Add new item
                    </button>
                </div>

                <div class="card-body">
                    @if (!$items->first())
                    <h3 class="text-center">No item added yet</h3>
                    @else
                    <table class="table table-bordered table-striped table-sm" id="">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Unit Measure</th>
                                <th>Unit Amount</th>
                                <th>Max. Ratios</th>
                                <th>Ratio price</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $sno=1;
                            @endphp
                            @foreach ($items as $item)
                            <tr>
                                <td>@php
                                    echo $sno;$sno++;
                                    @endphp
                                </td>
                                <td>{{$item->item}}</td>
                                <td>{{$item->unit_measure}}</td>
                                <td>{{$item->unit_amount}}</td>
                                <td>{{$item->ratio_produced}}</td>
                                <td class="text-right">{{number_format(($item->price),2,'.',',')}}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-edit-{{$item->id}}">
                                        Edit
                                    </button>
                                    <!-- Start Modal edit -->
                                    <div class="modal fade" id="modal-edit-{{$item->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-edit-{{$item->id}}Label" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modal-edit-{{$item->id}}Label"> Edit Item
                                                        details
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('item-update') }}">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $item->id}}">
                                                        <div class="form-group row">
                                                            <label for="item" class="col-md-4 col-form-label text-md-right">{{ __('Item') }}</label>

                                                            <div class="col-md-8">
                                                                <input id="item" type="item" class="form-control @error('item') is-invalid @enderror" name="item" value="{{ $item->item }}" required autocomplete="item" autofocus>

                                                                @error('item')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="unit_amount" class="col-md-4 col-form-label text-md-right">{{ __('Unit Amount') }}</label>

                                                            <div class="col-md-4">
                                                                <input id="unit_amount" type="text" value="{{ $item->unit_amount}}" name="unit_amount" required class="form-control @error('unit_amount') is-invalid @enderror">

                                                                @error('unit_amount')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input id="unit_measure" type="text" name="unit_measure" required autocomplete="current-unit_measure" placeholder="Item unit measure eg (Kg)" value="{{$item->unit_measure}}" class="form-control @error('unit_measure') is-invalid @enderror">

                                                                @error('unit_measure')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Ratios per unit') }}</label>
                                                            <div class="col-md-4">
                                                                <input id="ratios" type="text" name="ratios" required value="{{ $item->ratio_produced}}" placeholder="Max Ratios" class="form-control @error('ratios') is-invalid @enderror">

                                                                @error('ratios')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>

                                                            <div class="col-md-4">
                                                                <input id="price" type="text" name="price" required value="{{ $item->price*$item->unit_amount }}" placeholder="Price per ratio" class="form-control @error('price') is-invalid @enderror">

                                                                @error('price')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Extra decription') }}</label>

                                                            <div class="col-md-8">
                                                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Optional description &hellip;" name="description">{{ $item->description }}</textarea>

                                                                @error('description')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="form-group row mb-0">
                                                            <div class="col-md-8 offset-md-4">
                                                                <button type="submit" class="btn btn-primary btn-block">
                                                                    {{ __('Update Item') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="edit-{{ $item->id }}" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal edit -->
                                </td>
                                <td>
                                    <form action="{{ route('item-destroy')}}" method="post" onsubmit="return confirm('delete this item?')">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$item->id}}">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Delete
                                        </button>
                                    </form>
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
<div class="modal fade" id="modal-add" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modal-addLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-addLabel">Add new item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('item-add') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="item" class="col-md-4 col-form-label text-md-right">{{ __('Item') }}</label>

                        <div class="col-md-8">
                            <input id="item" type="item" class="form-control @error('item') is-invalid @enderror" name="item" value="{{ old('item') }}" required autocomplete="item" autofocus>

                            @error('item')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="unit_amount" class="col-md-4 col-form-label text-md-right">{{ __('Unit Amount') }}</label>

                        <div class="col-md-4">
                            <input id="unit_amount" type="text" name="unit_amount" required autocomplete="current-unit_amount" value="{{ old('unit_amount') }}" class="form-control @error('unit_amount') is-invalid @enderror">

                            @error('unit_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <input id="unit_measure" type="text" name="unit_measure" required value="{{ old('unit_measure') }}" autocomplete="current-unit_measure" placeholder="Item unit measure eg (Kg)" class="form-control @error('unit_measure') is-invalid @enderror">

                            @error('unit_measure')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Ratios per unit') }}</label>
                        <div class="col-md-4">
                            <input id="ratios" type="text" name="ratios" required autocomplete="current-ratios" value="{{ old('ratios') }}" placeholder="Max Ratios" class="form-control @error('ratios') is-invalid @enderror">

                            @error('ratios')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <input id="price" type="text" name="price" required autocomplete="current-price" value="{{ old('price') }}" placeholder="Price per ratio" class="form-control @error('price') is-invalid @enderror">

                            @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Extra decription') }}</label>

                        <div class="col-md-8">
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Optional description &hellip;" name="description">{{ old('description') }}</textarea>

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
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
