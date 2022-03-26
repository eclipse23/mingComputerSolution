@extends('vue-layouts.app')

@section('content')
<div class="py-16 bg-gray-50 overflow-hidden lg:py-24">
    <div class="relative max-w-xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl">
      <svg class="hidden lg:block absolute left-full transform -translate-x-1/2 -translate-y-1/4" width="404" height="784" fill="none" viewBox="0 0 404 784" aria-hidden="true">
        <defs>
          <pattern id="b1e6e422-73f8-40a6-b5d9-c8586e37e0e7" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
            <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
          </pattern>
        </defs>
        <rect width="404" height="784" fill="url(#b1e6e422-73f8-40a6-b5d9-c8586e37e0e7)" />
      </svg>
  
      <div class="relative">
        <h2 class="text-center text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">Disclaimer</h2>
        <p class="mt-4 max-w-3xl mx-auto text-center text-xl text-gray-500">I am fully aware that: 
            <ul class="list-disc ml-64">
                <li>The website is only for the residence of Panabo City and neighboring cities and municipalities</li>
                <li>This website is only for order reservation of Ming Computer Solution products</li>
                <li>Order Delivery is not allowed in the store.</li>
                <li>E-payment has no refund policy.</li>
                <li>Ordering product and not picking up after 3 days will automatically cancel the transaction</li>
            </ul>
        </p>
      </div>
    </div>
  </div>
@endsection