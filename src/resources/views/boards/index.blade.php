<x-app-layout>
    @if (session('success'))
      <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ session('success') }}
      </div>
    @endif
    <div class="m-3 mx-32 grid grid-cols-3 gap-4 flex flex-wrap flex-row">
    @foreach ($boards as $board) <div
      class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
      <a href="#">
      @if ($board->image)
        <img class="rounded-t-lg" src="{{ asset('storage/photos/' . $board->image) }}" alt="Board Image">
      @else
        <img class="rounded-t-lg" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="Placeholder Image">
      @endif
      </a>
      <div class="p-5">
        <a href="#">
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $board->title }}</h5>
        </a>
        <p>by {{ $board->user->name }}</p>
        <p class="my-3 font-normal text-gray-700 dark:text-gray-400 break-words">{{ $board->description }}</p>
      </div>
    </div>
    @endforeach
  </div>
</x-app-layout>