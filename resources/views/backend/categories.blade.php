@extends('vue-layouts.app')

@section('content')
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
        <h1 class="text-xl leading-6 font-semibold text-gray-900">
            Categories
        </h1>
        </div>
    </header>
    <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Replace with your content -->
        <div class="px-4 py-4 sm:px-0">
            <div class="h-96">
                <categories></categories>
            </div>
        </div>
        <!-- /End replace -->
        </div>
    </main>
@endsection