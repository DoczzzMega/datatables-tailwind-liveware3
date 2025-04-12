<div class="flex flex-col max-w-[1200px] mx-auto">
    <div class="flex items-center justify-between py-3">
        <select wire:change="changeLimit($event.target.value)" class="py-3 px-4 pe-9 block max-w-[280px] border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
            @foreach($limitList as $k => $v)
                <option wire:click="changeLimit({{ $v }})" @if($v == $limit) selected @endif wire:key="{{ $k }}" value="{{ $v }}">{{ $v . ' записей на страницу' }}</option>
            @endforeach
        </select>

        <div class="max-w-[250px] space-y-3  ">
            <input wire:model.live.debounce.500ms="search" type="text" placeholder="Search..." class="py-2.5 sm:py-3 px-4 block w-full border border-gray-200 rounded-lg sm:text-sm focus:outline-none focus:border focus:border-blue-500 focus:ring focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
        </div>
    </div>


    <div class="flex flex-col w-full mx-auto border border-slate-200 p-3 rounded-xl mb-3">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                        <thead>
                        <tr>
                            <th scope="col" class="rounded-tl-md px-6 py-3 text-start text-xs font-medium bg-slate-100/70 text-gray-500 uppercase dark:text-neutral-500 cursor-pointer hover:bg-gray-200">
                                <div class="flex items-center justify-between">
                                    <span>Id</span>
                                    <img class="" width="18" src="{{asset('storage/img/arrow-down.svg')}}" alt="arrow-down">
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium bg-slate-100/70 text-gray-500 uppercase dark:text-neutral-500 cursor-pointer hover:bg-gray-200">Name</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium bg-slate-100/70 text-gray-500 uppercase dark:text-neutral-500 cursor-pointer hover:bg-gray-200">Email</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium bg-slate-100/70 text-gray-500 uppercase dark:text-neutral-500 cursor-pointer hover:bg-gray-200">Country</th>
                            <th scope="col" class="rounded-tr-md px-6 py-3 text-end text-xs font-medium bg-slate-100/70 text-gray-500 uppercase dark:text-neutral-500 cursor-pointer hover:bg-gray-200">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($users as $user)
                            <tr wire:key="{{ $user->id }}" class="odd:bg-white even:bg-gray-100 dark:odd:bg-neutral-900 dark:even:bg-neutral-800 hover:bg-gray-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $user->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-400 dark:text-neutral-200">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 dark:text-neutral-200">{{ $user->country->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    <button wire:click="deleteUser({{ $user->id }})" wire:confirm="Вы уверены, что хотите удалить этого пользователя?" type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-red-500 hover:cursor-pointer focus:outline-hidden focus:text-red-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">Delete</button>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div>
        {{ $users->onEachSide(1)->links(data: ['scrollTo' => false]) }}
    </div>


</div>
