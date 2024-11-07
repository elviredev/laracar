@props(['title' => '', 'bodyClass' => null])

<x-base-layout :title="$title" :$bodyClass>
  <x-layouts.header />

  {{-- Message Flash stockés en session --}}
  @session('success')
    <div class="container my-large">
      <div class="success-message">
        {{ session('success') }}
      </div>
    </div>
  @endsession

  {{ $slot }}
</x-base-layout>



