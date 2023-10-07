@extends('layout')
@section('content')
    <div id="app" class="main">
        <search :items="{{ json_encode(PropertiesHelper::getInitialProperties()) }}"
            :price='{{ json_encode(PropertiesHelper::getPriceOptions()) }}' />
    </div>
@endsection
