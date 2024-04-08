<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { reactive } from 'vue';

const showNotificationBubble = ref(0);

const phoneNumber = ref('987654321');

const handleNewNotification = () => {
  showNotificationBubble.value += 1;
};

const showNotification = () => {
  showNotificationBubble.value = !showNotificationBubble.value;
  if (showNotificationBubble.value) {
    notificationCount.value = 0; // Reset count when bubble is opened
  }
};


const props = defineProps({
  data: Array
})

const form = reactive({
  amount: null,
  interest_rate: null,
  loan_period: null,
});

const errors = reactive({
  amount: null,
  interest_rate: null,
  loan_period: null,
});

const loanDetails = reactive({
  emi: 0,
  total_interest: 0,
  total_payment: 0,
});

const logout = async () => {
  try {
    await axios.post('/logout/user');
    router.replace('/');
  } catch (error) {
    console.error('Logout failed', error);
  }
};


const submit = async () => {
    errors.amount = null;
    errors.interest_rate = null;
    errors.loan_period = null;
  axios.post('/loan/details', form).then(res => {
    var data = res.data.data;
    loanDetails.emi = data.emi;
    loanDetails.total_interest = data.total_interest;
    loanDetails.total_payment = data.total_payment;



    form.amount = null;
    form.interest_rate = null;
    form.loan_period = null;
    errors.amount = null;
    errors.interest_rate = null;
    errors.loan_period = null;

  }).catch(err => {
    var error = err.response.data.errors;
    errors.amount = error.amount ? error.amount[0] : null;
    errors.interest_rate = error.interest_rate ? error.interest_rate[0] : null;
    errors.loan_period = error.loan_period ? error.loan_period[0] : null;
  })
}


</script>
<template>
<div v-if="showNotificationBubble" class="notification-bubble">
  You have a new notification!
</div>
            <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                                </Link>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('user.loan')" :active="route().current('user.loan')">
                                    Loan
                                </NavLink>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('applyloan')" :active="route().current('applyloan')">
                                    Create Loan
                                </NavLink>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('affiliate')" :active="route().current('affiliate')">
                                    Affiliate
                                </NavLink>
                            </div>

                             <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('loan.calculator')" :active="route().current('loan.calculator')">
                                    Loan Calculator
                                </NavLink>
                            </div>

                             <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('contactus')" :active="route().current('contactus')">
                                    Contact Us
                                </NavLink>
                            </div>




                             <!-- <i class="fas fa-bell notification-icon mt-3 ml-5" @click="showNotification"></i> -->





                            <div class="hidden-space sm:-my-px sm:ms-10 sm:flex mt-2">
                                <form :action="route('logout.user')" method="post" @submit.prevent="logout">
                                    <button class="logout-button" type="submit">Logout</button>
                                </form>
                            </div>


                        </div>
                             <i class="fas fa-bell notification-icon mt-3 ml-5" @click="showNotification">
                                <span v-if="showNotificationBubble === 0" class="notification-count">{{ showNotificationBubble }}</span>
                            </i>

                               <a :href="'https://wa.me/' + phoneNumber" target="_blank" class="whatsapp-button">
                                 <i class="fab fa-whatsapp mt-4"></i>
                                </a>
                        <br/>
                       </div>
                     <div class="container">
                         <form @submit.prevent="submit" class="custom-form">
                          <label for="amount">Amount:</label>
                          <input id="amount" v-model="form.amount" class="small-input" placeholder="Enter Amount"/>
                          <p class="text-red-700" v-if="errors.amount">{{ errors.amount }}</p>

                         <label for="interest_rate">Interest Rate:</label>
                         <input id="interest_rate" v-model="form.interest_rate" class="small-input" placeholder="Enter interest rate %"/>
                         <p class="text-red-700" v-if="errors.interest_rate">{{ errors.interest_rate }}</p>

                        <label for="loan_period">Loan period:</label>
                        <input id="loan_period" placeholder="Enter loan Period in Year" v-model="form.loan_period" class="small-input" />
                         <p class="text-red-700" v-if="errors.loan_period">{{ errors.loan_period }}</p>

                        <button type="submit">Submit</button>
    </form>
  </div>
                        <div>

</div>

<div class="loan-info-container" v-if="loanDetails.emi > 0 || loanDetails.total_interest > 0 || loanDetails.total_payment > 0">
    <div class="loan-info">
      <div class="label">Loan EMI</div>
       <div class="value">&#8377;{{ loanDetails.emi }}</div>
    </div>

    <div class="loan-info">
      <div class="label">Total Interest Payable</div>
       <div class="value">&#8377;{{ loanDetails.total_interest }}</div>``
    </div>

    <div v-if="loanDetails.total_payment >0">
        <div class="loan-info">
      <div class="label">Total Payment (Principal + Interest)</div>
       <div class="value">&#8377;{{ loanDetails.total_payment }}</div>
    </div>

    </div>


  </div>

</template>

<style scoped>
.hidden-space {
    margin-right: 8px;
}

.logout-button {
    background-color: #3490dc;
    color: #ffffff;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.logout-button:hover {
    background-color: #2779bd;
}



.custom-form {
    max-width: 400px;
    margin: auto;

    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 8px;
}

.small-input {
    width: 100%;
    padding: 5px;
    margin-bottom: 16px;
    box-sizing: border-box;
}

button {
    background-color: #4caf50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

.loan-info-container {
    display: flex;
    justify-content: space-around;
    padding: 20px;
}

.loan-info {
    text-align: center;
}

.label {
    font-weight: bold;
    color: #333;
}

.value {
    font-size: 1.5em;
    color: #4caf50;
}

.notification-icon {
    cursor: pointer;
    font-size: 36px;
    /* Increase the font size for the bell icon */
    color: #cf17b7;
    position: relative;
}

.notification-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: #cf17b7;
    /* Use the same color as the icon */
    color: #ffffff;
    padding: 4px 8px;
    border-radius: 50%;
    font-size: 12px;
    /* Adjust the font size for the notification count */
}

.notification-bubble {
    position: absolute;
    top: 50px;
    right: 20px;
    background-color: #42cf17;
    color: #ffffff;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    z-index: 999;
    animation: fadeInUp 0.5s ease-out;
    /* Add a fade-in animation */
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}


.whatsapp-button {
    display: inline-block;
    margin-left: 10px;
    /* Adjust the spacing as needed */
    cursor: pointer;
    font-size: 24px;

    /* Adjust the font size as needed */
    color: #25d366;
    /* WhatsApp green color */
    text-decoration: none;
}

.whatsapp-button i {
    margin-right: 5px;
    margin-top: 4px;
    font-size: 40px;
    /* Adjust the spacing between icon and text */
}
</style>
