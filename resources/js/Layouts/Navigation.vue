<template>
  <aside
    class="z-20 hidden px-3 md:block flex-shrink-0 side-navbar"
    style="height: 100vh"
  >
    <div class="py-4 text-black-500 main-links-nav">
      <Link class="main-heading-logo ml-6 font-bold" :href="route('dashboard')">
        <img src="/images/web-logo.png" alt="">
      </Link>

      <ul class="mt-6 pl-0">
        <li class="relative px-6 py-3">
          <NavLink
            class="text-white"
            :href="route('dashboard')"
            :active="route().current('dashboard')"
          >
            <template #icon>
              <i class="fa-solid fa-house"></i>
            </template>
            <span class="text-white">Dashboard</span>
          </NavLink>
        </li>
        <li class="relative px-6 py-3" v-if="$page.props.auth.user.user_type == 1">
          <button
            @click="showingTwoLevelMenu_2 = !showingTwoLevelMenu_2"
            class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-black-800"
            aria-haspopup="true"
          >
            <span class="inline-flex items-center">
              <i class="fa-solid fa-home"></i
              ><span class="ml-4">Home Page</span>
            </span>
            <i class="fa-solid fa-caret-down"></i>
          </button>

          <ul
            v-show="showingTwoLevelMenu_2"
            class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-black-500 rounded-md shadow-inner bg-black-50"
            aria-label="submenu"
          >
            <li class="relative px-6 py-3">
              <NavLink
                class="text-white"
                :href="route('edit-home-page')"
                :active="route().current('edit-home-page')"
              >
                <template #icon>
                  <i class="fa-solid fa-slider"></i>
                </template>
                <span class="text-white">Slider</span>
              </NavLink>
            </li>
             <li class="relative px-6 py-3">
              <NavLink
                class="text-white"
                :href="route('category.index')"
                :active="route().current('category.index') "
              >
                <template #icon>
                  <i class="fa-solid fa-slider"></i>
                </template>
                <span class="text-white">Categories</span>
              </NavLink>
            </li>
             <li class="relative px-6 py-3">
              <NavLink
                class="text-white"
                :href="route('other_data')"
                :active="route().current('other_data')"
              >
                <template #icon>
                  <i class="fa-solid fa-slider"></i>
                </template>
                <span class="text-white">Other Data</span>
              </NavLink>
            </li>
            <!-- Add more <li> elements for additional submenu items -->
          </ul>
        </li>
        <li
          class="relative px-6 py-3"
          v-if="$page.props.auth.user.user_type == 1"
        >
          <NavLink
            class="text-white"
            :href="route('testimonial.index')"
            :active="route().current('dashboard')"
          >
            <template #icon>
              <i class="fas fa-comments"></i>
            </template>
            <span class="text-white">Testimonials</span>
          </NavLink>
        </li>

        <li
          class="relative px-6 py-3"
          v-if="$page.props.auth.user.user_type == 1"
        >
          <NavLink
            :href="route('customers')"
            :active="route().current('customers')"
          >
            <template #icon>
              <i class="fa-solid fa-users"></i>
            </template>
            <span class="text-white">Customers</span>
          </NavLink>
        </li>
        <li
          class="relative px-2 py-3"
          v-if="$page.props.auth.user.user_type == 1"
        >
          <NavLink
            :href="route('business-listing.index')"
            :active="route().current('business-listing.index')"
          >
            <i class="fa-solid fa-user-plus"></i>
            <span class="ml-4">Businesses</span>
          </NavLink>
        </li>
        <li
          class="relative px-2 py-3"
          v-if="$page.props.auth.user.user_type == 1"
        >
          <NavLink
            :href="route('jobs.index')"
            :active="route().current('jobs.index')"
          >
            <i class="fa-solid fa-tasks"></i>
            <span class="ml-4">Jobs</span>
          </NavLink>
        </li>
        <li
          class="relative px-2 py-3"
          v-if="$page.props.auth.user.user_type == 1"
        >
          <NavLink
            :href="route('contactus.listing')"
            :active="route().current('contactus.listing')"
          >
            <i class="fa-solid fa-user-plus"></i>
            <span class="ml-4">Enquiries</span>
          </NavLink>
        </li>

   
        <li
          v-if="$page.props.auth.user.user_type == 1"
          class="relative px-6 py-3"
        >
          <button
            @click="showingTwoLevelMenu_6 = !showingTwoLevelMenu_6"
            class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-black-800"
            aria-haspopup="true"
          >
            <span class="inline-flex items-center">
              <i class="fa-solid fa-gears"></i
              ><span class="ml-4">Settings</span>
            </span>

            <i class="fa-solid fa-caret-down"></i>
          </button>

          <ul v-show="showingTwoLevelMenu_6"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-black-500 rounded-md shadow-inner bg-black-50"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-black-800">
                            <NavLink :href="route('update-links.index')" :active="route().current('update-links.index')">
                              Logo Updation
                            </NavLink>
                        </li>
                    
          </ul>
        </li>
      </ul>
    </div>
  </aside>
</template>

<script>
import NavLink from "@/Components/NavLink.vue";
import { Link } from "@inertiajs/vue3";
import { ref, defineProps } from "vue";

export default {
  components: {
    NavLink,
    Link,
  },

  setup() {
    let showingTwoLevelMenu_1 = ref(false);
    let showingTwoLevelMenu_2 = ref(false);
    let showingTwoLevelMenu_3 = ref(false);
    let showingTwoLevelMenu_4 = ref(false);
    let showingTwoLevelMenu_5 = ref(false);
    let showingTwoLevelMenu_6 = ref(false);

    return {
      showingTwoLevelMenu_1,
      showingTwoLevelMenu_2,
      showingTwoLevelMenu_3,
      showingTwoLevelMenu_4,
      showingTwoLevelMenu_5,
      showingTwoLevelMenu_6,
    };
  },
};
</script>
<style scoped>
.side-navbar {
  position: sticky;
  top: 0;
}
.main-links-nav {
  height: 100%;
  overflow-y: auto;
}
.main-links-nav::-webkit-scrollbar {
  display: none;
}
</style>