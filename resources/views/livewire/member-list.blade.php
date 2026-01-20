<div class="p-4 sm:p-6 lg:p-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">会員一覧</h1>
            <p class="mt-2 text-sm text-gray-700">登録されている会員の一覧です。</p>
        </div>
    </div>

    <div class="mt-8">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="名前で検索..."
               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
    </div>

    <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                <a href="#" wire:click.prevent="sortBy('name')">名前</a>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                <a href="#" wire:click.prevent="sortBy('rank')">ランク</a>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                使用ラバー
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                戦型
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                <a href="#" wire:click.prevent="sortBy('win_rate')">勝率</a>
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                <a href="#" wire:click.prevent="sortBy('last_visit_date')">最終来館日</a>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($members as $member)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $member->name }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $member->rank }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $member->rubber }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $member->style }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $member->win_rate }}%</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $member->last_visit_date }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                    該当する会員が見つかりませんでした。
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
