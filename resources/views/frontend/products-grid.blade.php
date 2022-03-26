@extends('vue-layouts.app')

@section('content')
    <product-grid :page-data="{{ json_encode($data) }}"></product-grid>
@endsection