@props(['bracketStructure1'])

        
        

        

        <div class="flex flex-col gap-10 ">
            @foreach(['P97', 'P98'] as $matchId)
                <div class="match-box connector-right" id="octavos-{{ $matchId }}">
                    <label class="text-[10px] font-bold text-gray-400">{{ $matchId }}</label>
                    <div class="flex flex-col gap-3">
                            @foreach($bracketStructure1[$matchId] as $match)
                                @if ($match) 
                                   
                                        <div x-data="{ open: false, selectedTeam: null }" class="relative w-44">
                                            <button @click="open = !open" type="button" 
                                                    class="w-full bg-white border border-gray-300 rounded-md shadow-sm px-4 py-2 flex items-center justify-between hover:bg-gray-50 focus:outline-none">
                                                
                                                <div class="flex items-center gap-3">
                                                    <template x-if="selectedTeam">
                                                        <img :src="'images/flags/'+ selectedTeam.code +'.png'" alt=""
                                                            class="w-6 h-4 object-cover">
                                                    </template>
                                                    <span x-text="selectedTeam ? selectedTeam.name : 'Selecc'"></span>
                                                </div>

                                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                            </button>

                                            <ul x-show="open" @click.away="open = false" 
                                                class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base overflow-auto border border-gray-200">
                                                @php
                                                    // Aquí consultas tu modelo WorldCupMatch
                                                    $game = \App\Models\WorldCupMatch::where('match_number', $match)->with('team1', 'team2')->first();
                                                @endphp
                                                
                                                @if($game)
                                                    <form action="{{ route('predictions.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="game_id" value="{{ $game->id }}">
                                                        
                                                        <div class="flex flex-col gap-2">
                                                        <li @click="selectedTeam = {name: '{{ $game->team1->fifa_code }}', code: '{{ $game->team1->fifa_code }}', id: {{ $game->team1->id }}}; open = false; $wire.selectTeam({{ $game->team1->id }})"
                                                        class="cursor-pointer hover:bg-indigo-600 hover:text-white px-4 py-2 flex items-center gap-3">
                                                            <label class="flex items-center justify-between p-2 border rounded cursor-pointer hover:bg-gray-50">
                                                                <div class="flex items-center gap-2">
                                                                    <img src="{{ $game->team1->flag_url }}" class="w-6 h-4">
                                                                    <span>{{ $game->team1->fifa_code }}</span>
                                                                </div>
                                                                
                                                            </label></li>
                                                            <li @click="selectedTeam = {name: '{{ $game->team2->fifa_code }}', code: '{{ $game->team2->fifa_code }}', id: {{ $game->team2->id }}}; open = false; $wire.selectTeam({{ $game->team2->id }})"
                                                        class="cursor-pointer hover:bg-indigo-600 hover:text-white px-4 py-2 flex items-center gap-3">
                                                            <label class="flex items-center justify-between p-2 border rounded cursor-pointer hover:bg-gray-50">
                                                                <div class="flex items-center gap-2">
                                                                    <img src="{{ $game->team2->flag_url }}" class="w-6 h-4">
                                                                    <span>{{ $game->team2->fifa_code }}</span>
                                                                </div>
                                                            
                                                            </label></li>
                                                        </div>
                                                    
                                                    </form>
                                                @else
                                                    <div class="text-gray-400 text-sm italic">Esperando clasificación...</div>
                                                @endif
                                            </ul>
                                        </div>
                                        
                                    

                                @endif
                        
                            @endforeach
                    </div>
                    
                </div>
            @endforeach

        </div>

            
    
