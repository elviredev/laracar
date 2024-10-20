@props(['title' => ''])

<x-base-layout :title="$title">
  <x-layouts.header />
  {{ $slot }}
</x-base-layout>



