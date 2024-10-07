<x-app-layout>
  @section('title', 'ダッシュボード')
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>
  <div class="top-wrapper relative">
    <div class="top-inner-text absolute inset-0 flex items-center justify-center text-white">
      <h1 class="text-4xl font-bold">RUNTEQ BOARD APP</h1>
    </div>
  </div>
</x-app-layout>