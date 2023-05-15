<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Subscription Table') }}
        </h2>
    </x-slot>
    @section('styles')
        <style>
            /* The switch - the box around the slider */
            .switch {
                position: relative;
                display: inline-block;
                width: 60px;
                height: 34px;
            }
            
            /* Hide default HTML checkbox */
            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }
            
            /* The slider */
            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #7e6262;
                -webkit-transition: .4s;
                transition: .4s;
            }
            
            .slider:before {
                position: absolute;
                content: "";
                height: 26px;
                width: 26px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                -webkit-transition: .4s;
                transition: .4s;
            }
            
            input:checked + .slider {
                background-color: #2196F3;
            }
            
            input:focus + .slider {
                box-shadow: 0 0 1px #2196F3;
            }
            
            input:checked + .slider:before {
                -webkit-transform: translateX(26px);
                -ms-transform: translateX(26px);
                transform: translateX(26px);
            }
            
            /* Rounded sliders */
            .slider.round {
                border-radius: 34px;
            }
            
            .slider.round:before {
                border-radius: 50%;
            }
        </style>
    @endsection
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>  
                @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{--  {{ __("Subsription!") }}  --}}
                    {{--  @include('Subscription.table');  --}}
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                          <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                            <div class="overflow-hidden">
                                @if(count($subscription) > 0)
                                <table class="min-w-full text-center text-sm font-light">
                                    <thead class="border-b font-medium dark:border-neutral-500">
                                        <tr style="background-color: bisque;">
                                            <th scope="col" class="px-6 py-4">Plan Name</th>
                                            <th scope="col" class="px-6 py-4">Subscription Name</th>
                                            <th scope="col" class="px-6 py-4">Price</th>
                                            <th scope="col" class="px-6 py-4">Quantity</th>
                                            <th scope="col" class="px-6 py-4">Trail Start At</th>
                                            <th scope="col" class="px-6 py-4">Trail End At</th>
                                            <th scope="col" class="px-6 py-4">Auto Renew</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ($subscription as $subscriptions )
                                            @if(isset($subscriptions->plan))
                                            
                                                <tr class="border-b border-success-200 bg-success-100 text-neutral-800" style="background-color: #cbd5e1;">
                                                    <td class="whitespace-nowrap px-6 py-4">{{ $subscriptions->plan->plan_name }}</td>
                                                    <td class="whitespace-nowrap px-6 py-4">{{ $subscriptions->name }}</td>
                                                    <td class="whitespace-nowrap px-6 py-4">{{ $subscriptions->plan->price }}</td>
                                                    <td class="whitespace-nowrap px-6 py-4">{{ $subscriptions->quantity }}</td>
                                                    <td class="whitespace-nowrap px-6 py-4">{{ $subscriptions->trial_ends_at }}</td>
                                                    <td class="whitespace-nowrap px-6 py-4">{{ $subscriptions->created_at }}</td>
                                                    <td class="whitespace-nowrap px-6 py-4">
                                                        <label class="switch">
                                                            @if($subscriptions->ends_at == null)
                                                                <input type="checkbox" checked id="v" class="switcher" value="{{ $subscriptions->name }}">
                                                           
                                                            @else
                                                                <input type="checkbox" class="switcher" value="{{ $subscriptions->name }}">
                                                            @endif
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                                
                                            @endif
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                                @else
                                    <h3> You have not Subscribed any Plan! </h3>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.switcher').click(function(){
                    {{--  var subscriptionName = $('.switcher').val();  --}}
                    var subscriptionName =  $(this).val();
                    if($(this).is(':checked')){
                        alert('Do you Want to Check Auto Renewal?' );
                        $.ajax({
                            url:'{{ route("subscription.resume") }}',
                            data: { subscriptionName },
                            type:"get",
                            success:function(response)
                            {
                                console.log(response);
                            },
                            error:function(respons)
                            {
                                console.log(respons);
                            }
                        })
                    }
                    else{
                        alert('Do you Want to Uncheck Auto Renewal?');
                        $.ajax({
                            url:'{{ route("subscription.cancel") }}',
                            data: {subscriptionName},
                            type:"get",
                            success: function(response)
                            {
                                alert(response);
                            },
                            error: function(response)
                            {
                                alert(respons);
                            }
                        })
                    }
                });
            });
    </script>
@endsection
</x-app-layout>
