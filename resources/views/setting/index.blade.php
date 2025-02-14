<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Setting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

           
            <div class=" grid grid-cols-1 gap-6">
    
                @foreach ($dataList as $item)
                    
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        
    
                        <form action="{{route('setting.store',['slug' => $item->slug])}}" method="post" enctype="multipart/form-data">
            
                            @csrf
            
                            <div class="grid gap-6 grid-cols-1">
                            
            
                                <div>
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white @error('name') text-red-700 @enderror">{{$item->heading}}</label>
    
                                    @if ($item->type == 1)
    
                                        <input type="text" id="content" name="content" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500  @error('name') bg-red-50 border-red-500 text-red-900 placeholder-red-700  @enderror"  value="{{$item->content}}" />
    
                                    @elseif ($item->type == 2)
    
                                        <textarea id="message" rows="4" name="content" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >{{$item->content}}</textarea>
    
                                    
                                    @elseif ($item->type == 3)

                                    <div class="flex space-x-8">

                                        <div>
                                            <img src="{{asset('/storage/'.$item->content)}}" class="w-44 " alt="" srcset="">
                                        </div>

                                        <div>

                                            <div class="space-y-2">
                                                <label class="block text-sm font-medium text-gray-900 dark:text-white">
                                                    Upload file
                                                </label>
                                                <label for="file_input" class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-gray-900 bg-gray-50 border border-gray-300 rounded-lg cursor-pointer dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600">
                                                    <span id="file_label" class="text-gray-500">Belum ada file yang dipilih</span>
                                                    <span class="bg-blue-600 text-white py-1 px-3 rounded-lg">Pilih File</span>
                                                </label>
                                                <input name="content" type="file" id="file_input" class="hidden">
                                            </div>
                                            

                                       

                                        </div>

                       

                                    </div>    

                                    @else


                                        
                                    @endif
    
                                    
            
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
    
                                <div>
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Simpan</button>
            
                                </div>
                            </div>
                        </form>
                        
    
                    </div>
                </div>
    
                @endforeach
            </div>
            

            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div> --}}
        </div>
    </div>

    @push('js')

    <script>
        document.getElementById('file_input').addEventListener('change', function() {
            const fileLabel = document.getElementById('file_label');
            if (this.files.length > 0) {
                fileLabel.textContent = this.files[0].name;
            } else {
                fileLabel.textContent = "Belum ada file yang dipilih";
            }
        });
    </script>
        
    @endpush

</x-app-layout>
