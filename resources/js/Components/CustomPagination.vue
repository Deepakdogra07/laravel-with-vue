<template>
    <div v-if="links.length > 1">
        <div class="-mb-1 flex flex-wrap align-items-center pagination-links">
            <template v-for="(link, key) in links">
                <div div v-if="link.url === null" :key="key" class="mr-1   px-2 py-1 text-sm leading-4 text-white-400">
                    <i v-if="key == 0" class="fa-solid fa-chevron-left"></i><i v-else-if="key + 1 == links.length"
                        class="fa-solid fa-chevron-right"></i><span v-else>{{ link.label }}</span>
                </div>
                <div v-else>
                    <!-- <div v-if="key < 5 || link.active"> -->
                    <Link :key="key + 1"
                        class="main-page-links mr-1 mb-1 text-white px-2 py-1 text-sm leading-4"
                        :class="link.active ? 'border  border-white rounded-sm bg-white bg-opacity-25' : ''" :href="link.url"><i v-if="key == 0"
                        class="fa-solid fa-chevron-left"></i><i v-else-if="key + 1 == links.length"
                        class="fa-solid fa-chevron-right"></i><span v-else>{{ link.label }}</span></Link>
                    <!-- </div> -->
                    <!-- <div v-if="links.length - 3 < key">
                    <Link :key="key + 1" class="mr-1 mb-1 rounded border px-2 py-1 text-sm leading-4 hover:bg-white focus:border-indigo-500 focus:text-indigo-500" :class="{ 'text-white bg-purple-600 hover:bg-purple-600': link.active }" :href="link.url" >{{ link.label  }}</Link>
                </div> -->
                </div>
            </template>
        </div>
    </div>
</template>
  
<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    links: Array,
});
</script>