<x-app-layout>
   <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
               <div class="p-6 text-gray-900 dark:text-gray-100 col-2">
                  <div class="w-full lg:w-full md:w-full">
                     @if (session('status'))
                     <div class="alert alert-sucess" role="alert">
                        {{  session('status') }}
            
                     </div>
                        
                     @endif
            
                     <form  class="bg-zinc-200 shadow-md rounded px-8 pt-6 pb-8 mb-4" action="{{ route('plan.save') }}" method="post" enctype="mu
                     ">
                        @csrf
                        <div class="mb-4">
                           <lable class="block text-gray-700 text-sm font-bold mb-2" for="username">Plan Name</lable>
                           <input type="text" name="plan_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Basic Plan">
                        </div>
               
                        <div class="mb-4">
                           <lable class="block text-gray-700 text-sm font-bold mb-2" for="username">Amount</lable>
                           <input type="number" name="amount" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="100$">
                        </div>
               
                        <div class="mb-4">
                           <lable class="block text-gray-700 text-sm font-bold mb-2" for="username">Currency</lable>
                           <input type="text" name="currency" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="USD">
                        </div>
               
                        <div class="mb-4">
                           <lable class="block text-gray-700 text-sm font-bold mb-2" for="username">Interval Count</lable>
                           <input type="number" name="interval_count" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="1">
                        </div>
               
                        <div class="mb-4">
                           <lable class="block text-gray-700 text-sm font-bold mb-2" for="username">Billing Period</lable>
                           <select name="billing_period" id="billing_period" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                 <option value="week">Weekly</option>
                                 <option value="month" selected >Monthly</option>
                                 <option value="year">Yearly</option>
                           </select>
                        </div>
               
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">save</button>
            
                     </form>
                  </div>
               </div>
            </div>
         </div>
   </div>
   
</x-app-layout>

