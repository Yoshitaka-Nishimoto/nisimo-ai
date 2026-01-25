<div class="min-h-screen bg-gray-100 flex items-center justify-center p-4 font-sans">
    <div class="max-w-lg w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800">ピンポン・レジェンド</h1>
            <p class="text-gray-600">新しいメンバーを登録します</p>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white p-8 rounded-lg shadow-lg">
            <form wire:submit.prevent="save" class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">名前</label>
                    <input wire:model="name" id="name" type="text"
                           class="mt-1 block w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                           placeholder="山田 太郎">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Rank -->
                <div>
                    <label for="rank" class="block text-sm font-medium text-gray-700">ランク</label>
                    <select wire:model="rank" id="rank"
                            class="mt-1 block w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500">
                        <option value="">選択してください</option>
                        <option value="初級">初級</option>
                        <option value="中級">中級</option>
                        <option value="上級">上級</option>
                    </select>
                    @error('rank') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Rubber -->
                <div>
                    <label for="rubber" class="block text-sm font-medium text-gray-700">使用ラバー</label>
                    <input wire:model="rubber" id="rubber" type="text"
                           class="mt-1 block w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                           placeholder="テナジー05">
                    @error('rubber') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Style -->
                <div>
                    <label for="style" class="block text-sm font-medium text-gray-700">戦型</label>
                    <input wire:model="style" id="style" type="text"
                           class="mt-1 block w-full px-4 py-2 bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500"
                           placeholder="シェークハンド">
                    @error('style') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full py-3 px-4 bg-orange-500 text-white font-semibold rounded-md shadow-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    登録
                </button>
            </form>
        </div>
    </div>
</div>