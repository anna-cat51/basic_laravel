<x-app-layout>
  @section('title', '掲示板作成')
  <div class="bg-white w-full h-screen">
    <div class="w-1/2 mx-auto pt-6 px-8 pb-8">
      <h1 class="text-4xl">掲示板作成</h1>
      @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </div>
      @endif
      <form class="rounded mb-4" method="POST" action="{{ route('boards.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
            タイトル
          </label>
          <input
            class="shadow appearance-none border border-slate-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="title" type="text" name="title" value={{ old('title') }}>
        </div>
        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
            本文
          </label>
          <textarea id="description"
            class="shadow appearance-none border border-slate-300 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            rows="5" cols="33" name="description">{{ old('description') }}</textarea>
        </div>
        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="board_image">
              掲示板画像
          </label>
          <input id="board_image" class="w-full leading-tight" type="file" name="board_image">
        </div>
        <div class="flex items-center justify-between">
          <button
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            type="submit">
            登録する
          </button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>