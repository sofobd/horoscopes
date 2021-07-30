<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate Horoscopes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                        <form action="{{route('horoscopes.store')}}" method="POST">
                            @csrf

                            <div class="sm:max-w-md mt-6">
                                <div class="p-3 col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <x-label for="year" :value="__('Year')" />
                                        <select name="year" id="year">
                                            <option value="">Select year</option>
                                            @for($i = $year; $i<=$year+10; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="p-3 col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <x-label for="zodiac_signs" :value="__('Zodiac Sign')" />
                                        <select name="zodiac_signs" id="zodiac_signs">
                                            <option value="">Select Zodiac Sign</option>
                                            @foreach($zodiac_signs as $sign)
                                                <option value="{{$sign->id}}">{{$sign->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <x-button type="submit" class="ml-3">Submit</x-button>
                                </div>
                            </div>

                        </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
