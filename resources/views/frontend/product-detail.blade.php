@extends('vue-layouts.app')

@section('content')
    <product-detail :data="{{ json_encode($data) }}"></product-detail>
@endsection