

<x-app-layout>
    <x-slot name="header">
        <h2  id="test" class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                  <table class="shadow-lg bg-white table-auto">
      <tr>
        <th class="text-gray-600 bg-blue-100 border text-left px-8 py-4">Company</th>
        <th class="text-gray-600 bg-blue-100 border text-left px-8 py-4">Contact</th>
        <th class="text-gray-600 bg-blue-100 border text-left px-8 py-4">Country</th>
      </tr>
      <tr>
        <td class="border px-8 py-4">
          Alfreds Futterkiste
        </td>
        <td class="border px-8 py-4">Dante Sparks</td>
        <td class="border px-8 py-4">Italy</td>
      </tr>
      <tr>
        <td class="border px-8 py-4">Centro comercial Moctezuma</td>
        <td class="border px-8 py-4">Neal Garrison</td>
        <td class="border px-8 py-4">Spain</td>
      </tr>
      <tr>
        <td class="border px-8 py-4">Ernst Handel</td>
        <td class="border px-8 py-4">Maggie O'Neill</td>
        <td class="border px-8 py-4">Austria</td>
      </tr>
    </table>



                  <script>

                  console.log('fdsfdfdsfd!!!!!!!!!!!');
                  console.log(document.querySelectorAll('#test').outerHTML;

                  </script>



                      <div class="px-3 py-4 flex justify-center">
                          <table class="w-full text-md bg-white shadow-md rounded mb-4">
                              <tbody>
                                  <tr class="border-b">
                                      <th class="text-left p-3 px-5">Name</th>
                                      <th class="text-left p-3 px-5">Email</th>
                                      <th class="text-left p-3 px-5">Role</th>
                                      <th></th>
                                  </tr>
                                  <tr class="border-b hover:bg-orange-100 bg-gray-100">
                                      <td class="p-3 px-5"><input type="text" value="user.name" class="bg-transparent"></td>
                                      <td class="p-3 px-5"><input type="text" value="user.email" class="bg-transparent"></td>
                                      <td class="p-3 px-5">
                                          <select value="user.role" class="bg-transparent">
                                              <option value="user">user</option>
                                              <option value="admin">admin</option>
                                          </select>
                                      </td>
                                      <td class="p-3 px-5 flex justify-end"><button type="button" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Save</button><button type="button" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button></td>
                                  </tr>
                                  <tr class="border-b hover:bg-orange-100">
                                      <td class="p-3 px-5"><input type="text" value="user.name" class="bg-transparent"></td>
                                      <td class="p-3 px-5"><input type="text" value="user.email" class="bg-transparent"></td>
                                      <td class="p-3 px-5">
                                          <select value="user.role" class="bg-transparent">
                                              <option value="user">user</option>
                                              <option value="admin">admin</option>
                                          </select>
                                      </td>
                                      <td class="p-3 px-5 flex justify-end"><button type="button" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Save</button><button type="button" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button></td>
                                  </tr>

                                  <tr class="border-b hover:bg-orange-100">
                                      <td class="p-3 px-5"><input type="text" value="user.name" class="bg-transparent"></td>
                                      <td class="p-3 px-5"><input type="text" value="user.email" class="bg-transparent"></td>
                                      <td class="p-3 px-5">
                                          <select value="user.role" class="bg-transparent">
                                              <option value="user">user</option>
                                              <option value="admin">admin</option>
                                          </select>
                                      </td>
                                      <td class="p-3 px-5 flex justify-end"><button type="button" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Save</button><button type="button" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button></td>
                                  </tr>
                                  <tr class="border-b hover:bg-orange-100 bg-gray-100">
                                      <td class="p-3 px-5"><input type="text" value="user.name" class="bg-transparent"></td>
                                      <td class="p-3 px-5"><input type="text" value="user.email" class="bg-transparent"></td>
                                      <td class="p-3 px-5">
                                          <select value="user.role" class="bg-transparent">
                                              <option value="user">user</option>
                                              <option value="admin">admin</option>
                                          </select>
                                      </td>
                                      <td class="p-3 px-5 flex justify-end"><button type="button" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Save</button><button type="button" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button></td>
                                  </tr>
                                  <tr class="border-b hover:bg-orange-100">
                                      <td class="p-3 px-5"><input type="text" value="user.name" class="bg-transparent"></td>
                                      <td class="p-3 px-5"><input type="text" value="user.email" class="bg-transparent"></td>
                                      <td class="p-3 px-5">
                                          <select value="user.role" class="bg-transparent">
                                              <option value="user">user</option>
                                              <option value="admin">admin</option>
                                          </select>
                                      </td>
                                      <td class="p-3 px-5 flex justify-end"><button type="button" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Save</button><button type="button" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button></td>
                                  </tr>
                                  <tr class="border-b hover:bg-orange-100 bg-gray-100">
                                      <td class="p-3 px-5"><input type="text" value="user.name" class="bg-transparent"></td>
                                      <td class="p-3 px-5"><input type="text" value="user.email" class="bg-transparent"></td>
                                      <td class="p-3 px-5">
                                          <select value="user.role" class="bg-transparent">
                                              <option value="user">user</option>
                                              <option value="admin">admin</option>
                                          </select>
                                      </td>
                                      <td class="p-3 px-5 flex justify-end"><button type="button" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Save</button><button type="button" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button></td>
                                  </tr>
                                  <tr class="border-b hover:bg-orange-100">
                                      <td class="p-3 px-5"><input type="text" value="user.name" class="bg-transparent"></td>
                                      <td class="p-3 px-5"><input type="text" value="user.email" class="bg-transparent"></td>
                                      <td class="p-3 px-5">
                                          <select value="user.role" class="bg-transparent">
                                              <option value="user">user</option>
                                              <option value="admin">admin</option>
                                          </select>
                                      </td>
                                      <td class="p-3 px-5 flex justify-end"><button type="button" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Save</button><button type="button" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button></td>
                                  </tr>
                                  <tr class="border-b hover:bg-orange-100">
                                      <td class="p-3 px-5"><input type="text" value="user.name" class="bg-transparent"></td>
                                      <td class="p-3 px-5"><input type="text" value="user.email" class="bg-transparent"></td>
                                      <td class="p-3 px-5">
                                          <select value="user.role" class="bg-transparent">
                                              <option value="user">user</option>
                                              <option value="admin">admin</option>
                                          </select>
                                      </td>
                                      <td class="p-3 px-5 flex justify-end"><button type="button" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Save</button><button type="button" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">Delete</button></td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>








                      BLOG
                      CONTACT
                      CONTENT
                      CTA
                      ECOMMERCE
                      FEATURE
                      FOOTER
                      GALLERY
                      HEADER
                      HERO
                      PRICING
                      STATISTIC
                      STEP
                      TEAM
                      TESTIMONIAL
                      Copied!
                      <section class="text-gray-600 body-font">
                        <div class="container px-5 py-24 mx-auto">
                          <div class="flex flex-col text-center w-full mb-20">
                            <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">Pricing</h1>
                            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Banh mi cornhole echo park skateboard authentic crucifix neutra tilde lyft biodiesel artisan direct trade mumblecore 3 wolf moon twee</p>
                          </div>
                          <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                            <table class="table-auto w-full text-left whitespace-no-wrap">
                              <thead>
                                <tr>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">Plan</th>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">Speed</th>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">Storage</th>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">Price</th>
                                  <th class="w-10 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td class="px-4 py-3">Start</td>
                                  <td class="px-4 py-3">5 Mb/s</td>
                                  <td class="px-4 py-3">15 GB</td>
                                  <td class="px-4 py-3 text-lg text-gray-900">Free</td>
                                  <td class="w-10 text-center">
                                    <input name="plan" type="radio">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="border-t-2 border-gray-200 px-4 py-3">Pro</td>
                                  <td class="border-t-2 border-gray-200 px-4 py-3">25 Mb/s</td>
                                  <td class="border-t-2 border-gray-200 px-4 py-3">25 GB</td>
                                  <td class="border-t-2 border-gray-200 px-4 py-3 text-lg text-gray-900">$24</td>
                                  <td class="border-t-2 border-gray-200 w-10 text-center">
                                    <input name="plan" type="radio">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="border-t-2 border-gray-200 px-4 py-3">Business</td>
                                  <td class="border-t-2 border-gray-200 px-4 py-3">36 Mb/s</td>
                                  <td class="border-t-2 border-gray-200 px-4 py-3">40 GB</td>
                                  <td class="border-t-2 border-gray-200 px-4 py-3 text-lg text-gray-900">$50</td>
                                  <td class="border-t-2 border-gray-200 w-10 text-center">
                                    <input name="plan" type="radio">
                                  </td>
                                </tr>
                                <tr>
                                  <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">Exclusive</td>
                                  <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">48 Mb/s</td>
                                  <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">120 GB</td>
                                  <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3 text-lg text-gray-900">$72</td>
                                  <td class="border-t-2 border-b-2 border-gray-200 w-10 text-center">
                                    <input name="plan" type="radio">
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
                            <a class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">Learn More
                              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                                <path d="M5 12h14M12 5l7 7-7 7"></path>
                              </svg>
                            </a>
                            <button class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">Button</button>
                          </div>
                        </div>
                      </section>




                      <table class="table-auto">
                        <thead>
                          <tr>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Author</th>
                            <th class="px-4 py-2">Views</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="border px-4 py-2">Intro to CSS</td>
                            <td class="border px-4 py-2">Adam</td>
                            <td class="border px-4 py-2">858</td>
                          </tr>
                          <tr class="bg-gray-100">
                            <td class="border px-4 py-2">A Long and Winding Tour of the History of UI Frameworks and Tools and the Impact on Design</td>
                            <td class="border px-4 py-2">Adam</td>
                            <td class="border px-4 py-2">112</td>
                          </tr>
                          <tr>
                            <td class="border px-4 py-2">Intro to JavaScript</td>
                            <td class="border px-4 py-2">Chris</td>
                            <td class="border px-4 py-2">1,280</td>
                          </tr>
                        </tbody>
                      </table>







                      <button class="modal-open bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full">Open Modal</button>

                       <!--Modal-->
                       <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
                         <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

                         <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

                           <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
                             <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                               <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                             </svg>
                             <span class="text-sm">(Esc)</span>
                           </div>

                           <!-- Add margin if you want to see some of the overlay behind the modal-->
                           <div class="modal-content py-4 text-left px-6">
                             <!--Title-->
                             <div class="flex justify-between items-center pb-3">
                               <p class="text-2xl font-bold">Simple Modal!</p>
                               <div class="modal-close cursor-pointer z-50">
                                 <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                   <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                                 </svg>
                               </div>
                             </div>

                             <!--Body-->
                             <p>Modal content can go here</p>
                             <p>...</p>
                             <p>...</p>
                             <p>...</p>
                             <p>...</p>

                             <!--Footer-->
                             <div class="flex justify-end pt-2">
                               <button onclick="toggleModal()" class="px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2">Action</button>
                               <button onclick="toggleModal()" class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Close</button>
                             </div>

                           </div>
                         </div>
                       </div>

                       <script>
                       toggleModal();
                         var openmodal = document.querySelectorAll('.modal-open')
                         for (var i = 0; i < openmodal.length; i++) {
                           openmodal[i].addEventListener('click', function(event){
                         	event.preventDefault()
                         	toggleModal()
                           })
                         }

                      /*   const overlay = document.querySelector('.modal-overlay')
                         overlay.addEventListener('click', toggleModal)*/

                        /* var closemodal = document.querySelectorAll('.modal-close')
                         for (var i = 0; i < closemodal.length; i++) {
                           closemodal[i].addEventListener('click', toggleModal)
                         }*/

                         /*document.onkeydown = function(evt) {
                           evt = evt || window.event
                           var isEscape = false
                           if ("key" in evt) {
                         	isEscape = (evt.key === "Escape" || evt.key === "Esc")
                           } else {
                         	isEscape = (evt.keyCode === 27)
                           }
                           if (isEscape && document.body.classList.contains('modal-active')) {
                         	toggleModal()
                           }
                         };*/


                         function toggleModal () {
                           const body = document.querySelector('body')
                           const modal = document.querySelector('.modal')
                           modal.classList.toggle('opacity-0')
                           modal.classList.toggle('pointer-events-none')
                           body.classList.toggle('modal-active')
                         }


                       </script>










                </div>
            </div>
        </div>
    </div>
</x-app-layout>
