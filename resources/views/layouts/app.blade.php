@props(['title' => '', 'bodyClass' => null])

<x-base-layout :title="$title" :$bodyClass>
  <x-layouts.header />
  {{ $slot }}
</x-base-layout>



