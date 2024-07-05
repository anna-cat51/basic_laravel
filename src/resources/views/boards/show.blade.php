<x-app-layout>
  <section class="text-gray-600 body-font w-2/3 mx-auto p-2">
    <div class="container my-12 flex px-5 py-24 md:flex-row flex-col items-center bg-white">
      <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
        <img class="object-cover object-center rounded" alt="hero" src={{ Storage::url("images/".$board->image) }}
          width="400">
      </div>
      <div
        class="lg:flex-grow md:w-1/2 lg:pl-4 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
        <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
          {{ $board->title }}
        </h1>
        <div class="flex">
          <p class="mb-8 leading-relaxed">
            by {{ $board->user->name }}
          </p>
          <p class="mb-8 ml-4 leading-relaxed">
            {{ $board->created_at->format('d M Y') }}
          </p>
        </div>
        <p class="mb-8 leading-relaxed">
          {{ $board->description }}
        </p>
      </div>
    </div>
  </section>
</x-app-layout>