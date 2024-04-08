<template>

    <aside class="z-20 hidden px-3 md:block flex-shrink-0 side-navbar" style="height: 100vh;">
        <div class="py-4 text-black-500 main-links-nav">

            <Link class="main-heading-logo ml-6 font-bold" :href="route('dashboard')">
            Unstopable
            </Link>

            <ul class="mt-6 pl-0">
                <li class="relative px-6 py-3">
                    <NavLink class="text-white" :href="route('dashboard')" :active="route().current('dashboard')">
                        <template #icon>
                            <i class="fa-solid fa-house"></i>
                        </template>
                       <span class="text-white">Dashboard</span>
                    </NavLink>
                </li>

                <li class="relative px-6 py-3" v-if="$page.props.auth.user.user_type == 1">
                    <NavLink class="text-white" :href="route('news.index')" :active="route().current('dashboard')">
                        <template #icon>
                            <i class="fas fa-newspaper"></i>
                        </template>
                       <span class="text-white">News</span>
                    </NavLink>
                </li>

                <li class="relative px-6 py-3" v-if="$page.props.auth.user.user_type == 1">
                    <NavLink class="text-white" :href="route('testimonial.index')" :active="route().current('dashboard')">
                        <template #icon>
                           <i class="fas fa-comments"></i>
                        </template>
                       <span class="text-white">Testimonials</span>
                    </NavLink>
                </li>


                <!-- <li class="relative px-6 py-3">
                    <button @click="showingTwoLevelMenu_1 = !showingTwoLevelMenu_1"
                        class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-black-800"
                        aria-haspopup="true">
                        <span class="inline-flex items-center">
                            <i class="fa-solid fa-users"></i>
                            <span class="ml-4">Users</span>
                        </span>
                        <i class="fa-solid fa-caret-down"></i>
                    </button>
                    <ul v-if="$page.props.auth.user.user_type == 1" v-show="showingTwoLevelMenu_1"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-black-500 rounded-md shadow-inner bg-black-50"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-black-800">
                            <NavLink :href="route('agents')" :active="route().current('agents')">Agents</NavLink>
                        </li>
                    </ul>
                    <ul v-show="showingTwoLevelMenu_1"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-black-500 rounded-md shadow-inner bg-black-50"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-black-800">
                            <NavLink :href="route('customers')" :active="route().current('customers')">
                                Customers
                            </NavLink>
                        </li>
                    </ul>
                </li> -->




                <li class="relative px-6 py-3" v-if="$page.props.auth.user.user_type == 1">
                    <NavLink :href="route('customers')" :active="route().current('customers')">
                        <template #icon>
                            <i class="fa-solid fa-users"></i>
                        </template>
                       <span class="text-white">Customers</span>
                    </NavLink>
                </li>


                <li class="relative px-2 py-3" v-if="$page.props.auth.user.user_type == 1">
                    <NavLink :href="route('listing')" :active="route().current('listing')">
                        <i class="fa-solid fa-user-plus"></i> <span class="ml-4">Agents</span>
                    </NavLink>
                </li>







                <!-- <li class="relative px-6 py-3">
                    <button @click="showingTwoLevelMenu_2 = !showingTwoLevelMenu_2"
                        class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-black-800"
                        aria-haspopup="true">
                        <span class="inline-flex items-center">
                            <i class="fa-solid fa-landmark"></i>
                            <span class="ml-4">Loan Management</span>
                        </span>
                        <i class="fa-solid fa-caret-down"></i>
                    </button>
                    <ul v-show="showingTwoLevelMenu_2"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-black-500 rounded-md shadow-inner bg-black-50"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-black-800">
                            <NavLink :href="route('loan.index')" :active="route().current('loan.index')">
                                All Loans
                            </NavLink>
                        </li>
                    </ul>

                    <ul v-show="showingTwoLevelMenu_2"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-black-500 rounded-md shadow-inner bg-black-50"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-black-800">

                            <NavLink :href="route('loans-approved')" :active="route().current('loans-approved')">
                            Approved Loans
                            </NavLink>
                        </li>
                    </ul>

                    <ul v-show="showingTwoLevelMenu_2" class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-black-500 rounded-md shadow-inner bg-black-50"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-black-800">
                            <NavLink :href="route('loans.rejected')" :active="route().current('loans.rejected')">
                            Rejected Loans
                            </NavLink>
                        </li>
                    </ul>
                    <ul v-show="showingTwoLevelMenu_2" class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-black-500 rounded-md shadow-inner bg-black-50"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-black-800">
                            <NavLink :href="route('deleted.loans')" :active="route().current('deleted.loans')">
                            Deleted Loans
                            </NavLink>
                        </li>
                    </ul>
                </li> -->




                <!-- <li v-if="$page.props.auth.user.user_type == 1" class="relative px-6 py-3">
                    <button @click="showingTwoLevelMenu_3 = !showingTwoLevelMenu_3"
                        class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-black-800"
                        aria-haspopup="true">
                        <span class="inline-flex items-center">
                            <i class="fa-solid fa-list"></i>
                            <span class="ml-4">Agent Management</span>
                        </span>
                        <i class="fa-solid fa-caret-down"></i>
                    </button>

                    <ul v-show="showingTwoLevelMenu_3"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-black-500 rounded-md shadow-inner bg-black-50"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-black-800">
                            <NavLink :href="route('listing')" :active="route().current('listing')">
                                Manage Agents
                            </NavLink>
                        </li>
                    </ul>

                </li> -->












                <!-- <li class="relative px-6 py-3" v-if="$page.props.auth.user.user_type == 1">
                    <button @click="showingTwoLevelMenu_4 = !showingTwoLevelMenu_4"
                        class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-black-800"
                        aria-haspopup="true">
                        <span class="inline-flex items-center">

                            <i class="fa-solid fa-list"></i>
                            <span class="ml-4">Affiliate Management</span>
                        </span>

                        <i class="fa-solid fa-caret-down"></i>
                    </button>
                    <ul v-show="showingTwoLevelMenu_4"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-black-500 rounded-md shadow-inner bg-black-50"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-black-800">
                            <NavLink :href="route('referrals')" :active="route().current('referrals')">
                                Affiliate List
                            </NavLink>
                        </li>
                    </ul>
                    <ul v-if="$page.props.auth.user.user_type == 1" v-show="showingTwoLevelMenu_4"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-black-500 rounded-md shadow-inner bg-black-50"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-black-800">
                            <NavLink :href="route('referrals.admin')" :active="route().current('referrals.admin')">
                               Admin Affiliate List
                            </NavLink>
                        </li>
                    </ul>
                </li> -->


                <!-- <li class="relative px-6 py-3">
                    <button @click="showingTwoLevelMenu_5 = !showingTwoLevelMenu_5"
                        class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-black-800"
                        aria-haspopup="true">
                        <span class="inline-flex items-center">

                            <i class="fa-solid fa-list"></i>
                            <span class="ml-4">Withdrawal Requests</span>
                        </span>

                        <i class="fa-solid fa-caret-down"></i>
                    </button>
                    <ul v-show="showingTwoLevelMenu_5"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-black-500 rounded-md shadow-inner bg-black-50"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-black-800">
                            <NavLink :href="route('withdraws')" :active="route().current('withdraws')">
                               Withdrawal Lists
                            </NavLink>
                        </li>
                    </ul>
                </li> -->


                <!-- <li class="relative px-2 py-3" v-if="$page.props.auth.user.user_type == 1">
                    <NavLink :href="route('withdraws')" :active="route().current('withdraws')">
                        <i class="fa-solid fa-wallet"></i><span class="ml-4">Withdrawal Lists</span>
                                </NavLink>
                </li> -->











                <li v-if="$page.props.auth.user.user_type == 1" class="relative px-6 py-3">
                    <button @click="showingTwoLevelMenu_6 = !showingTwoLevelMenu_6"
                        class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-black-800"
                        aria-haspopup="true">
                        <span class="inline-flex items-center">

                            <i class="fa-solid fa-gears"></i><span class="ml-4">Settings</span>
                        </span>

                        <i class="fa-solid fa-caret-down"></i>
                    </button>

                    <!-- <ul v-show="showingTwoLevelMenu_6"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-black-500 rounded-md shadow-inner bg-black-50"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-black-800">
                            <NavLink :href="route('add-commission')" :active="route().current('add-commission')">
                            Set Interest & Commission
                            </NavLink>
                        </li>
                    </ul>
                    <ul v-show="showingTwoLevelMenu_6"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-black-500 rounded-md shadow-inner bg-black-50"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-black-800">
                            <NavLink :href="route('add-contact')" :active="route().current('add-contact')">
                              Set Contact Details
                            </NavLink>
                        </li>
                    </ul>

                    <ul v-show="showingTwoLevelMenu_6"
                        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-black-500 rounded-md shadow-inner bg-black-50"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150 hover:text-black-800">
                            <NavLink :href="route('whatsapp')" :active="route().current('whatsapp')">
                                WhatsApp
                            </NavLink>
                        </li>
                    </ul> -->
                </li>
            </ul>
        </div>
    </aside>
</template>

<script>
import NavLink from '@/Components/NavLink.vue'
import { Link } from '@inertiajs/vue3';
import {ref, defineProps} from 'vue';


export default {
    components: {
        NavLink,
        Link,
    },

    setup() {
        let showingTwoLevelMenu_1 = ref(false)
        let showingTwoLevelMenu_2 = ref(false)
        let showingTwoLevelMenu_3 = ref(false)
        let showingTwoLevelMenu_4 = ref(false)
        let showingTwoLevelMenu_5 = ref(false)
        let showingTwoLevelMenu_6 = ref(false)

        return {
            showingTwoLevelMenu_1,
            showingTwoLevelMenu_2,
            showingTwoLevelMenu_3,
            showingTwoLevelMenu_4,
            showingTwoLevelMenu_5,
            showingTwoLevelMenu_6,

        }
    },
}
</script>
<style scoped>
.side-navbar{
    position: sticky;
    top: 0;
}
.main-links-nav{
    height: 100%;
    overflow-y: auto;
}
.main-links-nav::-webkit-scrollbar {
  display: none;
}
</style>