@extends('layouts.master')

@section('title', 'Pay')

@section('content')

    <div class="page-header">
        <h1>Payment Page</h1>
    </div>

    <form class="form-horizontal col-sm-6 col-sm-offset-2" action="/pay" method="post" accept-charset="utf-8" role="form">
        {!! csrf_field() !!}
        <div class="{{ $errors->has('name') ? 'form-group has-error':'form-group' }}">
            <label for="inputName" class="col-sm-4 control-label">Name</label>
            <div class="col-sm-6">
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="inputName" placeholder="Firstname and lastname">
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="{{ $errors->has('gateway') ? 'form-group has-error':'form-group' }}">
            <label for="selectGateway" class="col-sm-4 control-label">Payment Gateway</label>
            <div class="col-sm-6">
                <select name="gateway" class="form-control" id="selectGateway">
                    @foreach($gateways as $gateway)
                    <option value="{{ $gateway['value'] }}" {{ old('gateway') == $gateway['value'] ? 'selected':'' }}>{{ $gateway['name'] }}</option>
                    @endforeach
                </select>
                {!! $errors->first('gateway', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="{{ $errors->has('value') || $errors->has('currency') ? 'form-group has-error':'form-group' }}">
            <label for="inputValue" class="col-sm-4 control-label">Value</label>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-6">
                        <input type="text" name="value" value="{{ old('value') }}" class="form-control" id="inputValue" placeholder="Amount">
                        {!! $errors->first('value', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="col-sm-6">
                        <select name="currency" class="form-control" id="selectCurrency">
                            <option value="TRY" {{ old('currency') == 'TRY' ? 'selected':'' }}>TRY</option>
                            <option value="USD" {{ old('currency') == 'USD' ? 'selected':'' }}>USD</option>
                            <option value="EUR" {{ old('currency') == 'EUR' ? 'selected':'' }}>EUR</option>
                        </select>
                        {!! $errors->first('currency', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-6">
                <button type="submit" class="btn btn-success btn-block">Pay</button>
            </div>
        </div>
    </form>

@endsection