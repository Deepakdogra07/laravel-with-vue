<template>
 <div class="container-fluid">
   <div class="row ">
     <div class="col-lg-3 col-md-4 px-0">
       <Navigation />
       <NavigationMobile />
     </div>

     <div class="col-lg-9 col-md-8 px-0">
       <TopMenu />

       <main class="">
         <div class="px-2" >
           <div class="pages-heading d-flex justify-between align-items-center px-2 py-3 text-2xl font-semibold text-gray-700">
             <slot name="header" />
           </div>

           <slot />
         </div>
       </main>
     </div>
   </div>
 </div>
</template>

<script setup>
import Navigation from './Navigation.vue';
import TopMenu from "./TopMenu.vue";
import NavigationMobile from './NavigationMobile.vue';
</script>
