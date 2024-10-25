@props(['title' => '', 'bodyClass' => ''])

<x-base-layout :$title :$bodyClass>
  <main>
    <div class="container-small page-login">
      <div class="flex" style="gap: 5rem">
        <div class="auth-page-form">
          {{-- Logo --}}
          <div class="text-center">
            <a href="/">
              <img src="/img/logoipsum-265.svg" alt=""/>
            </a>
          </div>
          {{ $slot }}
          {{-- Buttons Google et Fb --}}
          <div class="grid grid-cols-2 gap-1 social-auth-buttons">
            <x-google-button />
            <x-fb-button />
          </div>
          {{-- Footer Link (slot nommé)  --}}
          <div class="login-text-dont-have-account">
            {{ $footerLink }}
          </div>
        </div>
        {{-- Image --}}
        <div class="auth-page-image">
          <img src="/img/car-png-39071.png" alt="" class="img-responsive"/>
        </div>
      </div>
    </div>
  </main>
</x-base-layout>