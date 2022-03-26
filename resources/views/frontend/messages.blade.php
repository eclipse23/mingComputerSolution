@extends('vue-layouts.app')

@section('content')
    <messages :datas="{{ json_encode($data) }}"></messages>
@endsection