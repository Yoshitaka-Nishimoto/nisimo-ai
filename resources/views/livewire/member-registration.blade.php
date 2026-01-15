<div class="min-h-screen bg-[#FDFDFD] flex items-center justify-center p-6 font-sans antialiased text-slate-900">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-block p-4 bg-[#FDE047] rounded-full mb-4 shadow-sm animate-bounce">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h1 class="text-4xl font-black tracking-tight italic uppercase italic">Nano <span class="text-[#FDE047] bg-black px-2 py-1 rounded-lg">PingPong</span></h1>
            <p class="mt-2 text-slate-500 font-medium">Join our minimalist table tennis community.</p>
        </div>

        <!-- Success Message -->
        @if (isset($message))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-2xl font-bold text-center animate-fade-in">
                {{ $message }}
            </div>
        @else
        @endif

        <!-- Form Card -->
        <div class="bg-white p-10 rounded-[40px] shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-slate-100">
            <form wire:submit="register" class="space-y-8">
                
                <!-- Name Field -->
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">unique Name</label>
                    <input wire:model="name" type="text" 
                        class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-[#FDE047] transition-all duration-300 placeholder:text-slate-300"
                        placeholder="John Doe">
                    @error('name') <span class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</span> @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Email Address</label>
                    <input wire:model="email" type="email" 
                        class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-4 focus:ring-[#FDE047] transition-all duration-300 placeholder:text-slate-300"
                        placeholder="hello@nano-banana.com">
                    @error('email') <span class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</span> @enderror
                </div>
                @php $level=0;
                @endphp
                <!-- Skill Level (Nano Banana Style Radio) -->
                <div>
                    <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-4 ml-1">Select Skill Level</label>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach(['beginner' => '🐥', 'intermediate' => '🏓', 'advanced' => '🔥'] as $key => $emoji)
                            <label class="cursor-pointer group">
                                <input type="radio" wire:model="level" value="{{ $key }}" class="hidden">
                                <div @class([
                                    'flex flex-col items-center p-4 rounded-3xl border-2 transition-all duration-300',
                                    'bg-[#FDE047] border-[#FDE047] scale-105 shadow-lg' => $level === $key,
                                    'bg-white border-slate-100 hover:border-[#FDE047]' => $level !== $key,
                                ])>
                                    <span class="text-2xl mb-1">{{ $emoji }}</span>
                                    <span class="text-[10px] font-black uppercase">{{ $key }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full py-5 bg-black text-[#FDE047] rounded-[30px] font-black uppercase tracking-widest hover:bg-[#FDE047] hover:text-black transition-all duration-500 transform active:scale-95 shadow-xl shadow-yellow-200/50 flex items-center justify-center space-x-2">
                    <span wire:loading.remove>Join the Club</span>
                    <span wire:loading class="animate-spin text-2xl">🎾</span>
                </button>
            </form>
        </div>

        <!-- Footer Footer -->
        <p class="mt-8 text-center text-slate-400 text-xs font-medium">
            Powered by <span class="text-black font-bold">Nano Banana UI</span> & Laravel 12
        </p>
    </div>
</div>