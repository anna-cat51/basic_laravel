<nav aria-label="alternative nav">
    <div class="h-20 fixed top-10 mt-12 md:relative md:h-screen z-10 w-full md:w-48 content-center">
        <div
            class="md:mt-12 md:w-48 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
            <ul class="list-reset flex flex-row md:flex-col pt-3 md:py-3 px-1 md:px-2 text-center md:text-left">
                <li class="mr-3 flex-1">
                    <a href="{{ route('admin.users.index') }}"
                        class="block py-1 md:py-3 pl-0 md:pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-red-500">
                        <i class="ri-user-fill pr-0 md:pr-3 text-xm"></i><span
                            class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Users</span>
                    </a>
                </li>
                <li class="mr-3 flex-1">
                    <a href="{{ route('admin.boards.index') }}"
                        class="block py-1 md:py-3 pl-0 md:pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-red-500">
                        <i class="ri-clipboard-fill pr-0 md:pr-3 text-xm"></i><span
                            class="pb-1 md:pb-0 text-xs md:text-base text-gray-400 md:text-gray-200 block md:inline-block">Boards</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>